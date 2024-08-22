<?php

namespace App\Console\Commands;

use App\Models\User;
use ApiBrasil\Service;
use App\Models\Disparos;

use App\Models\Dispositivos;
use Illuminate\Console\Command;
use Illuminate\Queue\Middleware\WithoutOverlapping;

class SendMessagesCommand extends Command
{
    
    protected $signature = 'app:send-messages-command';
    protected $description = 'Responsible for sending messages to contacts';
    protected $expiresAfter = 36000 * 60; // 60 hours

    public function middleware()
    {
        return [new WithoutOverlapping('send-messages-command', 3600)];
    }

    public function handle()
    {

        $disparos = Disparos::where('status', 'pending')
        ->with('messagesPending')
        ->get();

        echo "Found " . count($disparos) . " pending dispatches\n";

        foreach ($disparos as $disparos) {

            $user = User::find($disparos->user_id);

            // dd($user->bearer_token_api_brasil);
            $token = $user->bearer_token_api_brasil;
            $devices_online = Dispositivos::online($user->id);

            if (count($devices_online) == 0) {
                echo "No devices online for user {$user->name}\n";
                continue;
            }

            $random_device = $devices_online[array_rand($devices_online)];
            $messagesPending = $disparos->messagesPending;

            if (count($messagesPending) == 0) {
                echo "No messages pending for user {$user->name}\n";
                continue;
            }

            $qt_disparo = 0;

            foreach ($messagesPending as $message) {

                $messageParsed = $this->parseMessage($message);

                switch ($disparos->mode) {
                    case 'agressive':
                        $random = rand(1, 10);
                        $sleep = rand(1, 2);
                        break;
                    case 'normal':
                        $random = rand(1, 5);
                        $sleep = rand(5, 60);
                        break;
                    case 'slow':
                        $random = rand(1, 2);
                        $sleep = rand(60, 120);
                        break;
                    default:
                        $random = rand(1, 10);
                        $sleep = rand(1, 2);
                        break;
                }

                echo "Disparo {$qt_disparo} de {$message->contato->name}\n";

                if ($qt_disparo >= $random) {
                    echo "Limit of {$random} messages reached, waiting {$sleep} seconds\n";
                    $qt_disparo = 0;
                    sleep($sleep);
                }

                if($message->template->type == 'text') {

                    $sendText = Service::WhatsApp("sendText", [
                        "Bearer" => $token,
                        "DeviceToken" => $random_device->device_token,
                        "body" => [
                            "number" => $message->contato->number,
                            "text" => $messageParsed
                        ]
                    ]);

                    if (!$sendText or !isset($sendText->response->result) or $sendText->response->result != 200) {
                        $message->status = 'error';
                        $message->log = json_encode($sendText);
                        $message->save();
                        continue;
                    }
                                        
                    $qt_disparo++;

                    $message->status = 'sent';
                    $message->send_at = now();
                    $message->save();
                    
                }

                if( $message->template->type == 'file' or $message->template->type == 'image' ) {

                    $sendFile = Service::WhatsApp("sendFile", [
                        "Bearer" => $token,
                        "DeviceToken" => $random_device->device_token,
                        "body" => [
                            "number" => $message->contato->number,
                            "path" => $message->template->path,
                            "options" => [
                                "caption" => $messageParsed,
                                "createChat" > true,
                                "filename" => basename($message->template->path)
                            ]
                        ]
                    ]);

                    if (!$sendFile or !isset($sendFile->response->result) or $sendFile->response->result != 200) {
                        $message->status = 'error';
                        $message->log = json_encode($sendFile);
                        $message->save();
                        continue;
                    }
                    
                    $qt_disparo++;

                    $message->status = 'sent';
                    $message->send_at = now();
                    $message->save();

                }

            }

            $disparos->status = 'finish';
            $disparos->save();

        }
    }

    function parseMessage($messageData)
    {

        //replace {nome} with the name of the contact
        $message = str_replace("{nome}", $messageData->contato->name, $messageData->template->text);

        // dd($message);

        //replace saudacao (bom dia)
        $message = str_replace("{saudacao}", $this->getSaudacao(), $message);

        //replace {hora} with the current time
        $message = str_replace("{hora}", date('H:i'), $message);

        //replace {data} with the current date
        $message = str_replace("{data}", date('d/m/Y'), $message);

        //tag {tag} with the name of the contact
        $message = str_replace("{tag}", $messageData->tag->name, $message);

        //random number 10 digits
        $message = str_replace("{random}", rand(1000000000, 9999999999), $message);

        return $message;

    }

    function getSaudacao()
    {
        $hora = date('H');

        if ($hora >= 0 && $hora < 12) {
            return "Bom dia";
        }

        if ($hora >= 12 && $hora < 18) {
            return "Boa tarde";
        }

        if ($hora >= 18 && $hora < 24) {
            return "Boa noite";
        }
    }
}
