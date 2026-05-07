<?php

namespace App\Http\Controllers;

use App\Models\Port;
use Illuminate\Http\Request;
use Clickbar\Magellan\Data\Geometries\Point;
use Clickbar\Magellan\Database\PostgisFunctions\ST;

class PortController extends Controller
{
    // Show all ports
    public function index(Request $request)
    {
        $query = Port::query();

        // Search
        if ($request->search) {

            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('country', 'like', '%' . $request->search . '%');
        }

        $ports = $query->oldest()->paginate(5);

        return view('ports.index', compact('ports'));
    }

    // Store port
    public function store()
    {
        Port::create([
            'name' => 'Mumbai Port',
            'country' => 'India',
            'location' => Point::makeGeodetic(18.9388, 72.8354)
        ]);

        return redirect()
            ->back()
            ->with('success', 'Port created successfully');
    }

    // Delete port
    public function destroy($id)
    {
        Port::findOrFail($id)->delete();

        return redirect()
            ->back()
            ->with('success', 'Port deleted successfully');
    }

    // Nearby ports
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