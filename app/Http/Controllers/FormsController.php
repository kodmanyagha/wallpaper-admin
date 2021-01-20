<?php

namespace App\Http\Controllers;

use App\Answer;
use App\AnswerElement;
use App\Category;
use App\Helpers\StringUtils;

class FormsController extends Controller
{
    public function index()
    {
        return $this->list();
    }

    public function list()
    {
        $title = __('Formlar') . ' (' . __('Listele') . ')';
        $this->set('titlePage', $title);
        return $this->view();
    }

    public function listDT()
    {
        header('Content-Type: application/json; charset=utf-8');

        $input  = request()->input();
        $start  = (int)request()->input('start');
        $length = (int)request()->input('length');
        $draw   = (int)request()->input('draw');
        $search = request()->input('search')['value'];

        $this->set('input', $input);
        $this->set('search', $search);

        $forms = Category::paginate($length);

        $data = [];
        $rows = $forms->items();
        foreach ($rows as &$row) {
            $data[] = [
                $row->id,
                $row->title,
                $row->status,
                $row->created_at,
                $row->slug
            ];
        }

        $total = $forms->total();
        $this->set('recordsTotal', $total);
        $this->set('recordsFiltered', $total);
        $this->set('draw', $draw);
        $this->set('data', $data);
        $this->set('forms', $forms);

        return $this->json();
    }

    public function addedit($id = null)
    {
        $id = (int)$id;

        if (request()->isMethod('post')) {
            $inputs = mo(request()->input());
            $inputs = o2s($inputs, TRUE);
            ee($inputs);

            return redirect('medical-branches/list');
        }

        $title = __('Formlar') . ' (' . ($id > 0 ? __('Düzenle') : __('Ekle')) . ') - (YAPIM AŞAMASINDA!!!)';
        $this->set('titlePage', $title);

        $result = null;
        $this->set('result', $result);

        return $this->view();
    }

    public function exportExcel($id)
    {
        $id = (int)$id;

        $form = Category::find($id);
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
        $form->formElements = $form->form_elements = mo($elements);

        $startDate = trim(@$_GET['startDate']);
        if (strlen($startDate) == 0)
            $startDate = date('Y-m-d', strtotime("last Monday"));

        $endDate = trim(@$_GET['endDate']);
        if (strlen($endDate) == 0)
            $endDate = date('Y-m-d', strtotime($startDate . " +6 days"));

        $startTime = trim(@$_GET['startTime']);
        if (strlen($startTime) == 0)
            $startTime = '00:00';

        $endTime = trim(@$_GET['endTime']);
        if (strlen($endTime) == 0)
            $endTime = '23:59:59';

        $answers = Answer::where('form_id', $id) //
        ->where('created_at', '>=', $startDate . ' ' . $startTime) //
        ->where('created_at', '<=', $endDate . ' ' . $endTime) //
        ->get();
        $answers = mo($answers);
        //lgi( $answers );

        $excelRows = [];
        $uniqids   = [];

        // questions
        $excelRow   = [];
        $excelRow[] = 'IP Adresi';
        $excelRow[] = 'Tarayıcı (UserAgent)';
        $excelRow[] = 'Tarih';
        foreach ($form->formElements as $elem) {
            if (StringUtils::startsWith($elem->type, 'form_')) {
                $title = trim(strip_tags($elem->title));
                if (strlen($title) > 100)
                    $title = substr($title, 0, 100) . '...';

                $excelRow[] = $title;
                $uniqids[]  = $elem->uniqid;
            }
        }
        $excelRows[] = $excelRow;

        // answers
        foreach ($answers as $answer) {
            $excelRow = [];

            $excelRow[] = $answer->ip;
            $excelRow[] = $answer->useragent;

            //$answer->created_at = explode( 'T', $answer->created_at );
            //$answer->created_at = $answer->created_at[ 0 ] . ' ' . explode( '.', $answer->created_at[ 1 ] )[ 0 ];
            //$answer->created_at = strtotime( $answer->created_at );
            //$answer->created_at = date( 'd.m.Y', $answer->created_at );
            $excelRow[] = $answer->created_at;

            foreach ($uniqids as $uniqid) {
                $elem = AnswerElement::where('answer_id', $answer->id)->where('form_element_uniqid', $uniqid)->first();
                if (is_null($elem))
                    $excelRow[] = "";
                else
                    $excelRow[] = $elem->answer;
            }
            $excelRows[] = $excelRow;
        }

        $fileName = date("Y_m_d_H_i_s") . ' ' . $form->title . '.xlsx';
        $path     = storage_path('app/public/uploads/' . $form->id . '/');
        @mkdir($path);
        $path .= $fileName;
        StringUtils::createExcelFile($excelRows, $path);

        return response()->download($path);
    }
}
