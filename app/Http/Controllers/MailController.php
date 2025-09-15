<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmailTemplate;
use Mail;
use App\Utils\EmailUtils;

class MailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $emailTemplates = EmailTemplate::paginate( 20 );
        return view('dashboard.email.index', ['emailTemplates' => $emailTemplates]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.email.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name'    => 'required|min:1|max:64',
            'subject' => 'required|min:1|max:128',
            'content' => 'required|min:1',
        ]);
        $template = new EmailTemplate();
        $template->variables = $request->input('variables');
        $template->code = $request->input('code');
        $template->name = $request->input('name');
        $template->subject = $request->input('subject');
        $template->content = $request->input('content');
        $template->save();
        $request->session()->flash('message', 'Successfully created Email Template');
        return redirect()->route('mail.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)

    {
        $template = EmailTemplate::find($id);
        return view('dashboard.email.show', [ 'template' => $template ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $template = EmailTemplate::find($id);
        return view('dashboard.email.edit', [ 'template' => $template ]);
    }
    public function duplicate($id,Request $request)
    {
        $template = EmailTemplate::find($id);
        $template->name= $template->name."_COPY";
        $template->code= $template->code."_COPY";
        $template=new EmailTemplate($template->toArray());
        //EmailTemplate::create((array)$template);
        $template->save();
        $request->session()->flash('message', 'Copié');
        return redirect()->route('mail.index');
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name'    => 'required|min:1|max:64',
            'subject' => 'required|min:1|max:128',
            'content' => 'required|min:1',
        ]);
        $template = EmailTemplate::find($id);
        $template->variables = $request->input('variables');
        $template->name = $request->input('name');
        $template->subject = $request->input('subject');
        $template->content = $request->input('content');
        $template->save();
        $request->session()->flash('message', 'Succès');
        return redirect()->route('mail.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $template = EmailTemplate::find($id);
        if($template){
            $template->delete();
        }
        $request->session()->flash('message', 'Succès');
        return redirect()->route('mail.index');
    }

    public function prepareSend($id){
        $template = EmailTemplate::find($id);
        return view('dashboard.email.send', [ 'template' => $template ]);
    }

    public function send($id, Request $request){
        //dd($request->file());
        $template = EmailTemplate::find($id);
        EmailUtils::sendEmail( $request->email,$template->id, $request->variables,$request->file());
        $request->session()->flash('message', 'E-mail envoyé');
        return redirect()->route('mail.index');
    }
}
