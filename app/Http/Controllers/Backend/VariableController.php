<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Variable;
use App\Http\Requests\Backend\Variable\VariableCreateRequest;
use App\Http\Requests\Backend\Variable\VariableUpdateRequest;
use App\Http\Requests\Backend\Variable\VariableValueUpdateRequest;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Yajra\DataTables\Html\Builder;

/**
 * Class VariableController
 * @package App\Http\Controllers\Backend
 */
class VariableController extends Controller
{
    public $module = "variable";

    public function index(Builder $builder)
    {

        $list = Variable::orderBy('is_hidden')->orderBy('name')->get();

        $data['list'] = $list;

        return view('admin.view.variable.index_values', ['list' => $list]);
    }

    public function create()
    {
        $data['model'] = new Variable();

        $this->_fillAdditionTemplateData();

        return view('admin.view.variable.create', $data);
    }

    public function store(VariableCreateRequest $request)
    {
        $input = $request->only(['type', 'key', 'name', 'description', 'multilingual']);

        try {
            Variable::create($input);

            return redirect()->route('admin.variable.index');
        } catch (Exception $e) {
            return redirect()->back()->withInput();
        }
    }


    public function show($id)
    {
        return $this->edit($id);
    }

    public function edit($id)
    {
        try {
            $model = Variable::with('translations')->findOrFail($id);

            if ($model->is_hidden && !$this->user->hasAccess('superuser')) {
                return redirect()->route('admin.variable.index');
            }

            $this->_fillAdditionTemplateData();

            return view('views.variable.edit', compact('model'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin.variable.index');
        }
    }

    public function update($id, VariableUpdateRequest $request)
    {
        $input = $request->only(['type', 'key', 'name', 'description', 'multilingual']);

        try {
            $model = Variable::findOrFail($id);

            if ($model->is_hidden) {
                return redirect()->route('admin.variable.index');
            }

            $model->update($input);

            return redirect()->route('admin.variable.index');
        } catch (ModelNotFoundException $e) {
        } catch (Exception $e) {
            //
        }

        return redirect()->back();
    }


    public function updateValue(VariableValueUpdateRequest $request)
    {
        try {
            $model = Variable::findOrFail($request->get('variable_id'));

            if ($model->is_hidden && !$this->user->hasAccess('superuser')) {
                return [
                    'status'  => 'error',
                    'message' => trans('messages.update_error'),
                ];
            }

            $input = $request->except('type', 'key', 'name', 'description', 'multilingual');
            $input['value'] = isset($input['value']) ? $input['value'] : '';

            $model->fill($input);

            $model->save();

			if($model->multilingual) {
				$settings = $request->only(config('translatable.locales'));
				$lang_data = [];
				foreach ($settings as $lang => $fields) {

					$lang_data[$lang] = $model->translate($lang)->toArray();

					if(!is_array($fields)) {

						if(!is_array($lang_data[$lang])) $lang_data[$lang] = $fields;

					} else {

	                foreach ($fields as $key => $value) {
						if(is_array($value)) {
							foreach ($value as $ind=>$json)
							{
							 if(is_object($json)) {
								$uploaded = $json->storeAs('variables/'.$lang.'-'.$model->id, $json->hashName().'.'.$json->getClientOriginalName() , 'uploads');
					            if ($uploaded) {
					                $uploaded = \Storage::disk('uploads')->url($uploaded);
					            }
								$lang_data[$lang][$key][$ind] = $uploaded;
							 }
							}
						}elseif(is_object($value)) {
							$uploaded = $value->storeAs('variables/'.$lang.'-'.$model->id, $value->hashName().'.'.$value->getClientOriginalName() , 'uploads');
				            if ($uploaded) {
				                $uploaded = \Storage::disk('uploads')->url($uploaded);
				            }
							$lang_data[$lang][$key] = $uploaded;
						} else {
							if(!is_array($lang_data[$lang][$key])) $lang_data[$lang][$key] = $value;
						}
	                }

					}
	            }
				$model->fill($lang_data);

	            $model->save();
			}



            toastr()->success(__('admin_labels.success.update',['model' => ucfirst($this->module)]));

			return redirect()->route('admin.variable.index');
        } catch (ModelNotFoundException $e) {
            $message = trans('messages.record_not_found');
        } catch (Exception $e) {
            $message = trans('messages.update_error').': '.$e->getMessage();
        }

        toastr()->error('error');
        return redirect()->route('admin.variable.index');
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /variable/{id}
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        try {
            $model = Variable::findOrFail($id);

            if ($model->is_hidden && !$this->user->hasAccess('superuser')) {
                //FlashMessages::add('error', trans('messages.record_not_found'));

                return redirect()->route('admin.variable.index');
            }

            if (!$model->delete()) {
                //FlashMessages::add("error", trans("messages.destroy_error"));
            } else {
                //FlashMessages::add('success', trans("messages.destroy_ok"));
            }
        } catch (ModelNotFoundException $e) {
            //FlashMessages::add('error', trans('messages.record_not_found'));
        } catch (Exception $e) {
            //FlashMessages::add("error", trans('messages.delete_error').': '.$e->getMessage());
        }

        return redirect()->route('admin.variable.index');
    }

    /**
     * set to template addition variables for add\update variable
     */
    private function _fillAdditionTemplateData()
    {
        $types = [];
        foreach (app(Variable::class)->getTypes() as $key => $type) {
            $types[$key] = trans('labels.variable_type_'.$type);
        }
        $data['types'] = $types;
    }
}
