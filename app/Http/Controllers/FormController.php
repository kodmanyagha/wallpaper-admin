<?php

namespace App\Http\Controllers;

use App\Answer;
use App\AnswerElement;
use App\Category;
use App\Image;
use App\Jobs\ProcessAnswer;
use Illuminate\Support\Str;

class FormController extends Controller
{

    public function index($slug)
    {
        $form = Category::where('slug', $slug)->first();

        if (is_null($form))
            abort(404);

        $form->formElements;

        foreach ($form->formElements as &$element) {
            $element->properties = s2o($element->properties);
        }

        $elements = ma($form->formElements);
        usort($elements, function ($a, $b) {
            return (int)($a['order_no'] > $b['order_no']);
        });
        unset($form->formElements);
        unset($form->form_elements);
        $form->formElements = $form->form_elements = $elements;

        $this->set('form', $form);

        if (request()->isMethod('post')) {
            $input     = request()->input();
            $ip        = request()->ip();
            $useragent = request()->server('HTTP_USER_AGENT');

            $validationArr = [];
            foreach ($form['form_elements'] as $element) {
                if (!Str::of($element['type'])->startsWith('form_')) {
                    continue;
                }

                $validationRules = [];
                if ($element['required'] == 1)
                    $validationRules[] = 'required';

                $validationArr[$element['uniqid']] = implode('|', $validationRules);
            }

            $validatedInput = request()->validate($validationArr);

            $save            = new Answer();
            $save->form_id   = $form['id'];
            $save->ip        = $ip;
            $save->useragent = $useragent;
            $save->save();
            $answerId = $save->id;

            foreach ($validatedInput as $inputKey => $inputData) {
                $formElement = Image::where('uniqid', $inputKey)->first();

                $save                      = new AnswerElement();
                $save->answer_id           = $answerId;
                $save->form_id             = $form['id'];
                $save->form_element_id     = $formElement->id;
                $save->form_element_uniqid = $inputKey;
                $save->title               = $formElement->title;

                if ($formElement->type == "form_checkbox")
                    $save->answer = implode(", ", $inputData);
                else
                    $save->answer = $inputData;

                $save->save();
            }
            ProcessAnswer::dispatch($answerId);

            //ee($validatedInput, $input);
            return redirect($slug . '/tesekkur');
        }

        //ee(mo($form));
        return $this->view();
    }

    public function thankYou($slug)
    {
        $form = Category::where('slug', $slug)->first();

        if (is_null($form))
            abort(404);

        $form->formElements;

        foreach ($form->formElements as &$element) {
            $element->properties = s2o($element->properties);
        }

        $elements = ma($form->formElements);
        usort($elements, function ($a, $b) {
            return (int)($a['order_no'] > $b['order_no']);
        });
        unset($form->formElements);
        unset($form->form_elements);
        $form->formElements = $form->form_elements = $elements;

        if (strlen($form->gratitude_title) > 0)
            $form->title = $form->gratitude_title;
        else
            $form->title = 'Formu doldurduğunuz için teşekkür ederiz.';

        $this->set('form', $form);

        //ee(mo($form));
        return $this->view();
    }
}
