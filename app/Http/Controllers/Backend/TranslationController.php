<?php

namespace App\Http\Controllers\Backend;

use App\Classes\Meta;
use FlashMessages;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\TranslationUpdateRequest;
use App\Models\Translation;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class TranslationController extends Controller
{
    public $module = "translation";

    /**
     * @var array
     */
    public $locales = [];

    /**
     * TranslationController constructor.
     */
    public function __construct()
    {
        Meta::title(trans('labels.translations'));

        $this->getExistsLocales();
    }

    /**
     * @param string $group
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index($group)
    {
        abort_unless(\Gate::allows('translations_access'), 403);
        $page = request('page', 1);

        $list = $this->getGroupCollection($group);

        $total = $list->count();
        $list = $list->slice(($page - 1) * 50);

        $list = new LengthAwarePaginator(
            $list,
            $total,
            50,
            $page,
            [
                'path' => route('admin.' . $this->module . '.index', $group),
                'query' => [],
            ]
        );

        $data['locales'] = $this->locales;
        $data['list'] = $list;
        $data['group'] = $group;
        $data['page'] = $page;
        $data['page_title'] = trans('labels.translation_group_' . $group);
        $data['module'] = $this->module;

        request()->flush();

        return view('admin.view.' . $this->module . '.index', $data);
    }

    /**
     * @param \App\Http\Requests\Backend\TranslationUpdateRequest $request
     *
     * @return mixed
     */
    public function update(TranslationUpdateRequest $request)
    {
        $group = $request->route('group');

        $db_translations = Translation::where(['group' => $group])
            ->get();

        foreach ($this->locales as $locale) {
            $translations = $request->get($locale);

            $locale_exist_translations = $this->getLocaleExistTranslationsForGroup($locale, $group);
            $translation = array_merge($locale_exist_translations, $translations);

            foreach ($translation as $key => $value) {
                $_translation = $db_translations->where('key', $key)->where('locale', $locale)->first();

                if (!$_translation) {
                    $_translation = new Translation(['locale' => $locale, 'group' => $group, 'key' => $key]);
                }

                $_translation->value = $value;

                $_translation->save();
            }

            if (Cache::getStore() instanceof \Illuminate\Cache\TaggableStore) {
                cache()->tags('translations')->forget($locale . '_' . $group);
            }

        }

        toastr()->success(__('admin_labels.success.update', ['model' => ucfirst($this->module)]));

        return redirect()->route(
            'admin.' . $this->module . '.index', ['group' => $group, 'page' => $request->input('page', 1)])->with('success', trans('messages.save_ok'));
    }

    /**
     * fill array of all physical exists locales
     */
    public function getExistsLocales()
    {
        $this->locales = config('app.locales');
    }

    /**
     * @param string $group
     * @param string $locale
     *
     * @return Collection
     */
    private function getGroupCollection($group, $locale = null)
    {
        $locales = $locale ? [$locale] : $this->locales;

        $list = [];
        foreach ($locales as $locale) {
            $path = app()->langPath() . '/' . $locale . '/' . $group . '.php';
            $_file_list = Arr::dot(include($path));

            $_translation = Translation::whereLocale($locale)->whereGroup($group)
                ->get(['key', 'value'])
                ->keyBy('key');

            foreach ($_file_list as $key => $item) {
                $list[$key][$locale] = $_translation->has($key) ? $_translation->get($key)->value : $item;
            }

            $_db_list = Arr::except($_translation->toArray(), array_keys($_file_list));

            foreach ($_db_list as $key => $item) {
                $list[$key][$locale] = $item['value'];
            }
        }

        ksort($list);

        return Collection::make($list);
    }

    /**
     * @param string $locale
     * @param string $group
     *
     * @return array
     */
    private function getLocaleExistTranslationsForGroup($locale, $group)
    {
        $list = [];

        foreach ($this->getGroupCollection($group, $locale) as $key => $translation) {
            $list[$key] = isset($translation[$locale]) ? $translation[$locale] : '';
        }

        return $list;
    }
}
