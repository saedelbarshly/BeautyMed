<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Sections;
use App\Books;
use App\Models\User;
use App\Writers;
use Response;

class BooksController extends Controller
{
    public function sections(Request $request)
    {
        $lang = $request->header('lang');
        $main_section = $request->header('section');
        if ($lang == '') {
            $resArr = [
                'status' => 'faild',
                'message' => trans('api.pleaseSendLangCode'),
                'data' => []
            ];
            return response()->json($resArr);
        }

        $sections = Sections::where('main_section',$main_section)
                                ->orderBy('name_'.$lang)
                                ->get();
        $list = [];
        foreach ($sections as $key => $value) {
            $list[] = $value->apiData($lang);
        }
        $resArr = [
            'status' => 'success',
            'message' => '',
            'data' => $list
        ];
        return response()->json($resArr);

    }
    public function sectionDetails(Request $request,$sectionId)
    {
        $lang = $request->header('lang');
        $main_section = $request->header('section');
        if ($lang == '') {
            $resArr = [
                'status' => 'faild',
                'message' => trans('api.pleaseSendLangCode'),
                'data' => []
            ];
            return response()->json($resArr);
        }

        $section = Sections::find($sectionId);
        $resArr = [
            'status' => 'success',
            'message' => '',
            'data' => $section != '' ? $section->apiData($lang) : ''
        ];
        return response()->json($resArr);

    }
    public function books(Request $request)
    {
        $lang = $request->header('lang');
        $section = $request->section;
        $publisher = $request->publisher;
        $writer = $request->writer;
        $name = $request->name;
        $language = $request->language;
        $type = $request->type;
        $rate = $request->rate;
        if ($lang == '') {
            $resArr = [
                'status' => 'faild',
                'message' => trans('api.pleaseSendLangCode'),
                'data' => []
            ];
            return response()->json($resArr);
        }

        //select from books
        $books = Books::orderBy('id','desc');

        //if selected section
        if ($section != '') {
            $sectionIds = [];
            $sectionData = Sections::find($section);
            if ($sectionData != '') {
                $sectionIds[] = $section;
                if ($sectionData->subSections != '') {
                    foreach ($sectionData->subSections as $key => $subSection) {
                        $sectionIds[] = $subSection->id;
                    }
                }
            }
            $books = $books->whereIn('section_id',$sectionIds);
        }

        //if selected writer
        if ($writer != '') {
            $writerData = Writers::find($writer);
            if ($writerData != '') {
                $books = $books->where('writer_id',$writer);
            }
        }

        //if selected publisher
        if ($publisher != '') {
            $publisherData = User::find($publisher);
            if ($publisherData != '') {
                $books = $books->where('publisher_id',$publisher);
            }
        }

        //if selected publisher
        if ($language != '') {
            $books = $books->where('language',$language);
        }

        if ($name != '') {
            $books = $books->where('name_ar', 'LIKE', "%".$name."%");
        }
        $books = $books->paginate(12);

        $list = [];
        foreach ($books as $key => $value) {
            $list[] = $value->apiData($lang);
        }
        $resArr = [
            'status' => 'success',
            'message' => '',
            'data' => $list
        ];
        return response()->json($resArr);

    }
    public function bookDetails(Request $request, $id)
    {
        $lang = $request->header('lang');
        if ($lang == '') {
            $resArr = [
                'status' => 'faild',
                'message' => trans('api.pleaseSendLangCode'),
                'data' => []
            ];
            return response()->json($resArr);
        }

        //select from books
        $bookDetails = Books::find($id);
        $resArr = [
            'status' => 'success',
            'message' => '',
            'data' => $bookDetails->apiData($lang,'1')
        ];
        return response()->json($resArr);

    }

}
