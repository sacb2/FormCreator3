<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Storage;

class FormSendMail extends Mailable
{
    use Queueable, SerializesModels;

    public $demo;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($demo)
    {
        $this->demo = $demo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        
         //$file=Storage::disk('local')->get('requirements1.xlsx');
      //   $file=Storage::disk('local')->path('requirements1.xlsx');
         setlocale(LC_ALL,"es_ES");
              return $this->from('decomcloud@lascondes.cl')
                     ->subject('Plataforma de Atenciones DECOM')
                     ->view('mail.form')
                     ->text('mail.form_plain')
                     ->with(
                       [
                             'testVarOne' => date("F j, Y"), 
                             'testVarTwo' => '2',
                       ]);
                 //      ->attach($file,[
                   //    ->attach(public_path('/img').'/seed_of_life.png', [
                     //          'mime' => 'application/vnd.ms-excel',
                       //        'as' => 'reporte.xlsx',
                       //]);
         
       // return $this->view('view.name');
    }

}
