<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactMessage;
use App\Helpers\AppHelper;

class ContactMessageController extends Controller
{
    public function addNewContactMessageFromClient(Request $contactDetails) {

        if ($contactDetails->name == null || empty($contactDetails->name)) {
            return (new AppHelper())->responseMessageHandle(0, 'Name is Required.');
        }

        if ($contactDetails->email == null || empty($contactDetails->email)) {
            return (new AppHelper())->responseMessageHandle(0, 'Email is Required.');
        }

        if ($contactDetails->mobile == null || empty($contactDetails->mobile)) {
            return (new AppHelper())->responseMessageHandle(0, 'Mobile is Required.');
        }

        if ($contactDetails->subject == null || empty($contactDetails->subject)) {
            return (new AppHelper())->responseMessageHandle(0, 'Subject is Required.');
        }

        if ($contactDetails->message == null || empty($contactDetails->message)) {
            return (new AppHelper())->responseMessageHandle(0, 'Message is Required.');
        }

        $contactMessage = ContactMessage::create([
            'name' => $contactDetails->name, 'email' => $contactDetails->email,
            'mobile' => $contactDetails->mobile, 'subject' => $contactDetails->subject,
            'message' => $contactDetails->message
        ]);

        if ($contactDetails != null) {
            $data['id'] = $contactMessage->id;
            $data['name'] = $contactMessage->name;
            $data['email'] = $contactMessage->email;
            $data['mobile'] = $contactMessage->mobile;
            $data['subject'] = $contactMessage->subject;
            $data['message'] = $contactMessage->message;

            return (new AppHelper())->responseEntityHandle(201, 'Message Created Successfully.', $data);
        } else {
            return (new AppHelper())->responseMessageHandle(0, 'There is Error Occured.');
        }
    }
}
