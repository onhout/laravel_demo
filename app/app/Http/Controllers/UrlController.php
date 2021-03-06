<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Url;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Jenssegers\Agent\Agent;
use App\Models\Click;

class UrlController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('url.index', ["urls" => Url::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        Url::create(array_merge($this->validateRequest(), ['user_id' => Auth::user()->id]));
        $validator = Validator::make($request->all(), [
            'original_url' => 'required|url',
        ]);
        if ($validator->fails()) {
            Session::flash('error', $validator->messages()->first());
            return redirect()->back()->withInput();
        } else {
            $url = new Url;
            $url->user_id = Auth::user()->id;
            $url->original_url = $request->original_url;
            $url->shortened_url = $url->create_slug();
            $url->save();
        }

        return redirect(route('urls.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param Url $url
     * @return \Illuminate\Http\Response
     */
    public function show(Url $url)
    {
        return view('url.show', ["url" => $url]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */

    public function redirect($shortened_url)
    {
        $agent = new Agent();
        $url = Url::whereRaw("BINARY `shortened_url` = ?", $shortened_url)->firstOrFail();
        Click::create([
            'url_id' => $url->id,
            'visitor' => request()->ip(),
            'browser' => $agent->browser(),
            'platform' => $agent->platform(),
            'language' => implode(',', $agent->languages())
        ]);

        return redirect()->away($url->original_url);
    }
}
