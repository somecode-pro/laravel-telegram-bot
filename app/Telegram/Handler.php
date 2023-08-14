<?php

namespace App\Telegram;

use DefStudio\Telegraph\Facades\Telegraph;
use DefStudio\Telegraph\Handlers\WebhookHandler;
use DefStudio\Telegraph\Keyboard\Button;
use DefStudio\Telegraph\Keyboard\Keyboard;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Stringable;

class Handler extends WebhookHandler
{
    public function hello(string $name): void
    {
        $this->reply("Привет, $name!");
    }

    public function help(): void
    {
        $this->reply('*Привет!* Пока я имею только говорить привет.');
    }

    public function actions(): void
    {
        Telegraph::message('Выбери какое-то действие')
            ->keyboard(
                Keyboard::make()->buttons([
                    Button::make('Перейти на сайт')->url('https://areaweb.su'),
                    Button::make('Поставить лайк')->action('like'),
                    Button::make('Подписаться')
                        ->action('subscribe')
                        ->param('channel_name', '@areaweb'),
                ])
            )->send();
    }

    public function like(): void
    {
        Telegraph::message('Спасибо за твой крутой лайк!')->send();
    }

    public function subscribe(): void
    {
        $this->reply("Спасибо за подписку на {$this->data->get('channel_name')}");
    }

    protected function handleUnknownCommand(Stringable $text): void
    {
        if ($text->value() === '/start') {
            $this->reply('Рад тебя видеть! Давай начнем пользоваться мной :-)');
        } else {
            $this->reply('Неизвестная команда');
        }
    }
}