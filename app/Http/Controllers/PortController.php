<?php

namespace App\Http\Controllers;

use App\Models\Port;
use Illuminate\Http\Request;
use Clickbar\Magellan\Data\Geometries\Point;
use Clickbar\Magellan\Database\PostgisFunctions\ST;

class PortController extends Controller
{
    public function index(Request $request)
    {
        $query = Port::query();

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('country', 'like', '%' . $request->search . '%');
            });
        }

        $ports = $query->oldest()->paginate(5)->withQueryString();

        return view('ports.index', compact('ports'));
    }

    public function searchSuggestions(Request $request)
    {
        $q = $request->q;

        if (!$q || strlen($q) < 2) {
            return response()->json(['suggestions' => []]);
        }

        $names = Port::where('name', 'like', '%' . $q . '%')
            ->pluck('name')
            ->take(4);

        $countries = Port::where('country', 'like', '%' . $q . '%')
            ->pluck('country')
            ->unique()
            ->take(2);

        $suggestions = $names->merge($countries)->unique()->values()->all();

        return response()->json(['suggestions' => $suggestions]);
    }

    public function store()
    {
        Port::create([
            'name'     => 'Mumbai Port',
            'country'  => 'India',
            'location' => Point::makeGeodetic(18.9388, 72.8354),
        ]);

        return redirect()->back()->with('success', 'Port created successfully');
    }

    public function destroy($id)
    {
        Port::findOrFail($id)->delete();

        return redirect()->back()->with('success', 'Port deleted successfully');
    }

    public function nearbyPorts()
    {
        $currentLocation = Point::makeGeodetic(19.0760, 72.8777);

        $ports = Port::select()
            ->addSelect(
                ST::distanceSphere($currentLocation, 'location')->as('distance')
            )
            ->orderBy(
                ST::distanceSphere($currentLocation, 'location')
            )
            ->paginate(5);

        return view('ports.nearby', compact('ports'));
    }
}