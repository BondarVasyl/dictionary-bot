<?php

namespace App\Http\Controllers;

use App\Api\v1\Drivers\BotDriver;
use Telegram\Bot\Laravel\Facades\Telegram;

class BotController extends Controller
{
    /**
     * @var BotDriver
     */
    private BotDriver $botDriver;

    public function __construct(BotDriver $botDriver)
    {
        $this->botDriver = $botDriver;
    }
    public function index()
    {
        $update = Telegram::commandsHandler(true);

        $this->botDriver->setLanguage(null, $update);

//        Log::info(['update' => $update]);

        $this->botDriver->analyzeText($update);

        $this->botDriver->assignAction($update);
    }
}
