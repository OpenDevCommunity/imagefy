<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\InviteAccepted;
use App\Mail\InviteDeclined;
use App\Mail\InviteRequested;
use App\Models\Invitation;
use Mail;
use RealRashid\SweetAlert\Facades\Alert;

class InviteController extends Controller
{

    public function index()
    {
        $pendingInvites = Invitation::where('accepted', 0)->get();
        return view('admin.invites.pending', [
            'pendingInvites' => $pendingInvites
        ]);
    }

    public function acceptInvite($id)
    {
        $invite = Invitation::find($id);

        if (!$invite) {
            return redirect()->back()
                ->with('error', 'Requested invite was not found!');
        }

        $invite->accepted = true;
        $invite->save();

        \Mail::to($invite->email)->send(new InviteAccepted($invite->email, $invite->getLink()));

        return redirect()->back()
            ->with('success', 'Invite request from ' . $invite->email . ' has been accepted!');
    }

    public function store()
    {
        // Check if user has an existing invite request
        $exists = Invitation::where('email', request()->email)->first();

        if ($exists) {
            toast('Existing request found for this email!', 'error');
            return redirect()->back();
        }

        $invitation = new Invitation(request()->all());
        $invitation->generateInvitationToken();
        $invitation->save();

        Mail::to(request()->get('email'))->send(new InviteRequested(request()->get('email')));

        toast('Invitation to register successfully sent', 'success');

        return redirect()->back();
    }


    public function create()
    {
        return view('admin.invites.create');
    }


    public function denyInvite($id)
    {
        $invite = Invitation::find($id);

        if (!$invite) {
            return redirect()->back()
                ->with('error', 'Requested invite was not found!');
        }

        // Send an email
        \Mail::to($invite->email)->send(new InviteDeclined($invite->email));

        Invitation::destroy($invite->id);

        return redirect()->back()
            ->with('success', 'Invite request from ' . $invite->email . ' has been denied!');
    }
}
