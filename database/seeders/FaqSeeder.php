<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Faq;

class FaqSeeder extends Seeder

{
    public function run()
    {
        // for testing purpose data. delete it after live production

        Faq::truncate();

        $faqs  = [
                array(
                    'question'    => 'How to make a video call',
                    'description' => 'Open the WhatsApp chat with the contact you want to'
                ),
                array(
                    'question'    => 'How to stay safe on WhatsApp',
                    'description' => 'The safety and security of you and your messages matter to us'
                ),
                array(
                    'question'    => 'About Temporarily Banned Accounts',
                    'description' => 'If you received an in-app message stating your account banned'
                ),
                array(
                    'question'    => 'About two-step verification',
                    'description' => 'Two-step verification is an optional feature that adds more security'
                ),
                array(
                    'question'    => 'How to restore your chat history',
                    'description' => 'To protect your account, WhatsApp will send you a push notification'
                )

           ];

           foreach ($faqs as $key => $faq) {
            Faq::create([
                    'question'     => $faq['question'],
                    'description'  => $faq['description'],
                ]);
            }
        }
    }