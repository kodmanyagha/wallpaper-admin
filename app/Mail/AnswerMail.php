<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Category;
use App\Answer;

class AnswerMail extends Mailable {
	use Queueable, SerializesModels;

	//
	private $answerId;

	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct($answerId) {
		$this->answerId = $answerId;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build() {
		$data = new \stdClass();
		$data->answer = Answer::find($this->answerId);
		$data->answer->answerElements;

		$data->form = Category::find($data->answer->form_id);
		$data->title = $data->form->title;

		$data = ma($data);
		return $this->subject($data['title'])->view('mail.answer', $data);
	}
}
