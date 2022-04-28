<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;

class SettingController extends Controller
{
    public function index()
    {
        return view('admin.view.settings.index', Setting::getSettings());
    }

    public function store(Request $request)
    {
        $key_value = null;
        $domen = null;

        foreach ($request->except('_token') as $key => $value) {
            $key_value = $key;
            $domen = $request->$key;
        }

        if ($key_value && $domen) {
            $setting_model = new Setting();

            $setting_model->deleteHookSetting();
            $setting_model->createNewSetting($key, $domen);

            return redirect(route('admin.settings.index'))
                ->with('status', __('admin_labels.settings_have_been_saved'));
        } else {
            return redirect(route('admin.settings.index'))
                ->with('status', __('admin_labels.domain_is_missing'));
        }
    }

    public function setWebhook(Request $request): \Illuminate\Http\RedirectResponse
    {
        if ($request->input('url')) {
            $result = $this->sendTelegramData(
                'setwebhook',
                [
                    'query' => [
                        'url' => $request->url . '/' . Telegram::getAccessToken()
                    ]
                ]
            );

            return redirect(route('admin.settings.index'))
                ->with('status', $result);
        } else {
            return redirect(route('admin.settings.index'))
                ->with('status', __('admin_labels.domain_is_missing'));
        }
    }

    public function getWebhookInfo(Request $request)
    {
        $result = $this->sendTelegramData('getWebhookInfo');

        return redirect(route('admin.settings.index'))->with('status', $result);
    }

    public function deleteWebhook()
    {
        $result = $this->sendTelegramData('deleteWebhook');

        return redirect(route('admin.settings.index'))->with('status', $result);
    }

    public function sendTelegramData($route = '', $params = [], $method = 'POST')
    {
        $client = new \GuzzleHttp\Client(
            [
                'base_uri' => 'https://api.telegram.org/bot' . \Telegram::getAccessToken() . '/'
            ]
        );
        try {
            $result = $client->request($method, $route, $params);
        } catch (GuzzleException $e) {
            return back()->withErrors($e->getMessage());
        }

        $result = (string)$result->getBody();

        return json_decode($result, true);
    }
}
