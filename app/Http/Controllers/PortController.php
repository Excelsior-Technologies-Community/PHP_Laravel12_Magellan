<?php

namespace App\Http\Controllers;

use App\Models\Port;
use Clickbar\Magellan\Data\Geometries\Point;
use Clickbar\Magellan\Database\PostgisFunctions\ST;

class PortController extends Controller
{

    public function store()
    {

        Port::create([
            'name' => 'Mumbai Port',
            'country' => 'India',
            'location' => Point::makeGeodetic(18.9388, 72.8354)
        ]);

        return "Port created successfully";
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
            ->get();

        return $ports;
    }
}
