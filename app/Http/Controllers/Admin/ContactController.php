<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Contact::query()
                ->orderByRaw("FIELD(status, 'unread', 'read', 'action_taken')")
                ->orderByDesc('id');

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('date', function ($row) {
                    return Carbon::parse($row->created_at)->format('d-m-Y H:i');
                })
                ->addColumn('status', function ($row) {
                    $options = [
                        'unread'       => 'warning',
                        'read'         => 'info',
                        'action_taken' => 'success',
                    ];
                    $html = '<select class="form-select form-select-sm status-select" data-id="' . $row->id . '" style="min-width:130px">';
                    foreach ($options as $val => $color) {
                        $selected = $row->status === $val ? 'selected' : '';
                        $label    = ucwords(str_replace('_', ' ', $val));
                        $html    .= '<option value="' . $val . '" ' . $selected . '>' . $label . '</option>';
                    }
                    $html .= '</select>';
                    return $html;
                })
                ->addColumn('action', function ($row) {
                    return '
                        <div class="dropdown">
                            <button class="btn btn-soft-secondary btn-sm" data-bs-toggle="dropdown">
                                <i class="ri-more-fill"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <button class="dropdown-item viewBtn" data-id="' . $row->id . '">
                                        <i class="ri-eye-fill me-2"></i>View
                                    </button>
                                </li>
                                <li class="dropdown-divider"></li>
                                <li>
                                    <button class="dropdown-item deleteBtn text-danger"
                                            data-delete-url="' . route('contacts.delete', $row->id) . '"
                                            data-method="DELETE"
                                            data-table="#contactTable">
                                        <i class="ri-delete-bin-fill me-2"></i>Delete
                                    </button>
                                </li>
                            </ul>
                        </div>';
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view('admin.contacts.index');
    }

    public function show($id)
    {
        $contact = Contact::find($id);

        if (!$contact) {
            return response()->json(['message' => 'Not found'], 404);
        }

        if ($contact->status === 'unread') {
            $contact->update(['status' => 'read']);
        }

        $contact->formatted_date = $contact->created_at->format('d-m-Y | H:i:s');

        return response()->json($contact);
    }

    public function toggleStatus(Request $request)
    {
        $contact = Contact::find($request->id);
        if (!$contact) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $request->validate(['status' => 'required|in:unread,read,action_taken']);
        $contact->update(['status' => $request->status]);

        return response()->json(['message' => 'Status updated successfully.']);
    }

    public function destroy($id)
    {
        $contact = Contact::find($id);
        if (!$contact) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $contact->delete();
        return response()->json(['message' => 'Deleted successfully.']);
    }
}