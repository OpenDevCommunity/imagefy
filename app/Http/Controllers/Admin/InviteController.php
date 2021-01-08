<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\InviteAccepted;
use App\Mail\InviteDeclined;
use App\Models\Invitation;
use Illuminate\Http\Request;

class InviteController extends Controller
{

    public function index()
    {
        $pendingInvites = Invitation::where('registered_at', NULL)->get();
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

        \Mail::to($invite->email)->send(new InviteAccepted($invite->email, $invite->getLink()));

        return redirect()->back()
            ->with('success', 'Invite request from ' . $invite->email . ' has been accepted!');
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
