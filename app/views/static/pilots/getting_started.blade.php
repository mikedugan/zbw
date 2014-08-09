@extends('layouts.master')
@section('title')
Getting Started
@stop
@section('content')

<h3>Boston ARTCC - Getting Started</h3>

<h2>Why We Encourage Preferred Routes</h2>

<p class="text-center">
    <img src="/images/pages/JFK_BOS_TRAFFIC.jpeg" alt="Preferred Routes" class="img-responsive text-center">
</p>

<p>
    Pilots filing flightplans within the Boston ARTCC may be offered a "preferred" route by the appropriate air
    traffic controller. There is a good reason why we emphasize the use of preferred routes. Here's just one example:
</p>

<p>
    We send traffic out of Boston to KJFK on the main preferred route via radar vectors LUCOS, then SEY067.SEY.PARCH.CCC.ROBER,
    crossing CCC at and maintain 12000/250kts. This southern routing [heavy yellow line] is away from the traffic orginating
    at KJFK via MERIT or over the JFK VOR for the JFK.ORW2 [broken red line] inbound to Boston. The more northern yellow line
    depicts the LOW altitude [17000ft or less] route from KBOS to KJFK via radar vectors BOSOX, then V419.V014.ORW.V016.DPK,
    with the handoff at YODER intersection no higher than 10000ft.
</p>

<p>
    This is a busy corridor of traffic, not only between KBOS-KJFK, but also involving KLGA and KEWR to and from KBOS.  This
    busy area requires separating departures from arrivals. Variants on the preferred flightplans are allowed only insomuch
    as they ensure this separation, and that the aircraft will enter the N90 New York Tracon as well as arrive at and depart
    from the A90 Boston Tracon at the proper handoff points.
</p>

<p>
    Pilots unable to fly preferred routes will be cleared on their chosen route only after receiving radar vectors to the
    proper departure gate, or fix, so as to maintain proper separation from arriving traffic.
</p>

<p>
    The following graphics illustrate our Major A90 Arrival and Departure Gates.
</p>

<p>
    <img src="/images/pages/A90_dep_gates.jpeg" alt="Departure Gates" class="img-responsive">
    Aircraft departing KBOS will be sent out of A90 via one of these DEPARTURE GATES. Yellow<BR>
    gates are HIGH altitude, Blue gates are LOW altitude [below FL180].
</p>

<p>
    <img src="/images/pages/A90_arr_gates.jpeg" alt="Arrival Gates" class="img-responsive">
    Aircraft arriving KBOS will be sent into A90 via one of these ARRIVAL GATES. WOONS1 arrival<BR>
    is for PROPS only. Your arrival gate depends on your STAR and direction of arrival.
</p>

<p>
    Boston Air Traffic Controllers are trained to offer preferred routes, not
    only when the flightplan involves KBOS and KJFK, but to all destinations from the Boston ARTCC.
</p>

<p>
    Spend some time reviewing this section of the website. Whether from
    <A HREF="/pilots/airport_info.php?icao=KALB">KALB</A>, <A HREF="/pilots/airport_info.php?icao=KBOS">KBOS</A>,
    <A HREF="/pilots/airport_info.php?icao=KMHT">KMHT</A>, <A HREF="/pilots/airport_info.php?icao=KBDL">KBDL</A>,
    <A HREF="/pilots/airport_info.php?icao=KBTV">KBTV</A>, <A HREF="/pilots/airport_info.php?icao=KPWM">KPWM</A>,
    <A HREF="/pilots/airport_info.php?icao=KPVD">KPVD</A>, <A HREF="/pilots/airport_info.php?icao=KSYR">KSYR</A>
    or Cape Cod, we have more than 1700 listed <A HREF="/pilots/route_search.php">routes</A> for your use.
    Simply go to one of these airports and scroll down to the routes
    section. Click the link for the type of route you want (High, Low, TEC) and you will see a list of
    matching routes. These plans are from the real-world FAA preferred routes database and will speed
    your clearance and departure out of Boston airspace.
</p>

<h2>Here Are Some Useful Tutorials</h2>
<p><a href="http://www.vatsim.net/prc/">How to Get Started with VATSIM, Squawkbox and FSInn (FS2002/FS9/FSX)</a></p>
<p><a href="http://www.vatsim.net/gettingstarted_2000.html">How to Get Started with Squawkbox and FS2000</a></p>
<p><a href="http://vatsim.net/howtoflyadp.html">How to Fly A Departure Procedure [DP]</a></p>
<p><a href="http://vatsim.net/star.html">How to Fly at Standard Terminal Arrival Procedure [STAR]</a></p>

@stop
