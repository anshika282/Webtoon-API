<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Author;
use App\Models\Genres;
use App\Models\Series;
use Illuminate\Http\Request;
use App\Http\Requests\SeriesRequest;
use Illuminate\Support\Facades\Validator;

class SeriesController extends Controller
{
    //POST API : to add new webtoon 
    public function addSeries(Request $request){

        $validation = Validator::make($request->all(),
        [
            'title' => 'required|string|max:255', 
            'author_name' => 'required',  
            'description' => 'nullable|string|max:1000', 
            'status' => 'required|in:ongoing,completed,onHiatus',
            'thumbnail' => 'nullable|string',
            'characters' => 'required|array',
            'characters.*.cname' => 'required|string|max:255', 
            'characters.*.summary' => 'nullable|string|max:1000', 
            'characters.*.role' => 'nullable|string|in:main,antagonist,supporting',
            'characters.*.image' => 'nullable|string'
        ]);

        if($validation->fails()){
            return response()->json($validation->errors(),400);
        }else{
            $series = $request->all();
            $author = Author::where('author_name',$series['author_name'])->first();
            $authorId = $author ? $author->id : "";
    
            $existing = Series::where('title',$series['title'])->where('author_id',$authorId)->first();
            \DB::beginTransaction();
    
            if(!$existing){
    
                if(!$author){
                    $author =  Author::create([
                        'author_name' => $series['author_name']
                     ]);
                     $authorId = $author->id;
                }
    
                $seriesNew = Series::create([
                    'title' => $series['title'],
                    'description' => $series['description'],
                    'author_id' => $authorId,
                    'thumbnail' =>$series['thumbnail'],
                    'status' => $series['status']
                ]);
                if($seriesNew){
                    foreach($request->characters as $character){
                        $seriesNew->character()->create([
                            'c_name' =>$character['cname'],
                            'webtoon_id' => $seriesNew->id,
                            'summary' => $character['summary'],
                            'role'=>$character['role'],
                            'image' => $character['image']
                        ]);
                    }
                }
                \DB::commit();
                return response()->json(['message'=>'Webtoon added Succesfully !','status'=>'success','data'=> $seriesNew->load('character')],201);

            }else{
                return response()->json(['message'=>'The webtoon already exists'],400);
            }
        }
    }

    //GET API : to get all the webtoon  :
    public function showSeries(){
        return response()->json([
            'webtoon' => Series::with('character')->get()
        ]);
    }

    //GET API : to fetch particular id of the webtoon
    public function showParticularSeries($id){
        $webtoon = Series::with('character')
            ->find($id);

        if (!$webtoon) {
            return response()->json(['message' => 'Webtoon not found'], 404);
        }
        return response()->json(['message'=>'successfully fetched', 'webtoon' =>$webtoon]);
    }

    //DELETE API : to delte a particular webtoon:

    public function deleteSeries($id){
        $webtoon = Series::find($id);
        if (!$webtoon) {
            return response()->json(['message' => 'Webtoon not found.'], 404);
        }
        $webtoon->delete();

        return response()->json(['message' => 'Webtoon deleted successfully.'], 200);
    }
}
