<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\InviteAccepted;
use App\Mail\InviteDeclined;
use App\Mail\InviteRequested;
use App\Models\Invitation;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Mail;

/**
 * Class InviteController
 * @package App\Http\Controllers\Admin
 */
class InviteController extends Controller
{

    /**
     * Render pending invitations page
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $pendingInvites = Invitation::where('accepted', 0)->get();

        return view('admin.invites.pending', [
            'pendingInvites' => $pendingInvites
        ]);
    }

    /**
     * Accept pending invitation
     *
     * @param $id
     * @return RedirectResponse
     */
    public function acceptInvite($id)
    {
        $invite = Invitation::find($id);

        if (!$invite) {
            toast('Requested invite was not found!', 'error');
            return redirect()->back();
        }

        $invite->accepted = true;
        $invite->save();

        \Mail::to($invite->email)->send(new InviteAccepted($invite->email, $invite->getLink()));

        toast('Invite request from ' . $invite->email . ' has been accepted!', 'success');
        return redirect()->back();
    }

    /**
     * Store newly created invitation
     *
     * @return RedirectResponse
     */
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

    /**
     * Deny pending invitation
     *
     * @param $id
     * @return RedirectResponse
     */
    public function denyInvite($id)
    {
        $invite = Invitation::find($id);

        if (!$invite) {
            toast('Requested invite was not found!', 'error');
            return redirect()->back();
        }

        // Send an emailgit
        \Mail::to($invite->email)->send(new InviteDeclined($invite->email));

        Invitation::destroy($invite->id);

        toast('Invite request from ' . $invite->email . ' has been denied!', 'success');
        return redirect()->back();
    }
}
