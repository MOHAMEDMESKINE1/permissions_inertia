<?php

namespace App\Http\Controllers;

use App\Mail\CoashMailEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CoashMailController extends Controller
{
    public function mail(){
        try {
            Mail::to('med.meskine1996@gmail.com')->send(new CoashMailEmail());
            return 'Email sent successfully!';
        } catch (\Exception $e) {
            return 'Failed to send email: ' . $e->getMessage();
        }
    }
}
