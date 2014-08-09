@extends('layouts.master')
@section('title')
Getting Started
@stop
@section('content')

<h3>VFR Tutorial</h3>



<h1>Class B and Class C Operations</h1>

<p>The most important fact here is that the VFR pilot is responsible for navigation and traffic avoidance in most classes of airspace. This is because in VMC the pilot better be able to navigate himself to the field. In the case of flight following a controller checks to ensure the pilot is “pointed” in the right direction issues traffic advisories and may provide vectors should the pilot go astray. Further if a pilot is given instructions by a controller that would put him/her in a cloudbank let’s say, the pilot must advise the controller of that. The controller may advise a heading change or advise lower in a few miles or minutes. In the BRAVO it’s 3mi and clear of clouds and in CHARLIE it’s 3mi and 500 ft below 1000ft above (only few or scattered layers for VFR pilots) 2000ft from. The weather minimums that designate whether a field is VFR or IFR are 3SM visibility and a ceiling of 1000ft AGL.</p>
<p>ATC never has the luxury of having a flight strip to refer to. As a matter of fact there is no mechanism
    in order for pilots to file plans that ATC facilities will have copies of. All VFR flight plans, and there is no real life requirement for them, are filed with FSS but strips are not generated at appropriate ATC facilities. So when pilots check in with ATC for VFR flight following or a departure out of a Class C or B field most often after being provided with a squawk code “they are entered into the NAS.” What does this mean? The NAS is the National Airspace System and provides information about the aircraft and its intended destination. So when ATC looks at the data block they have information about the flight and type of aircraft. In PC we can accomplish this by adding remarks to the contact. The problem is that ONLY you will have the remarks field visible. If you hand off the aircraft to another controller you’ll have to let the controller know the intended destination. Any other VFR pilot who neither requests entry into the BRAVO or CHARLIE airspace nor the associated mode C veil may squawk 1200 or not
    have their transponders on at all. In real life a controller will see a weak primary target when an aircraft is not squawking at all. The same holds true here in the virtual world.</p>

<p>The conventions discussed here are so that controllers and pilots alike can
    experience "as real as it gets." Obviously requesting a VFR pilot to resend
    his/her flight plan on PC is another means of addressing what is discussed
    here but isn’t REAL.</p>

<h1>VFR Traffic Pattern</h1>
<p>VFR traffic patterns have five legs: upwind, crosswind, downwind, base and final.</p>
<p>Pattern altitude at Logan is 1,500ft </p>
<div class="image"><img src="/images/pages/traffic_pattern.jpg" /></div>
<p class="caption">A Standard VFR Traffic Pattern</p>

<h2>Class B</h2>
<p>The Boston Consolidated TRACON Airspace encompasses 40-80nm around Boston
    to a height of 14,000ft. Within this airspace is a "BRAVO," within which VFR
    flight operations receive special handling</p>

<p>Depicted below is a 30nm "mode c" ring, which is NOT a part of the BRAVO. Within this 30nm radius every aircraft must have an operational transponder.</p>
<p>The Boston Class B horizontal and vertical limits are 20nm to 7000ft.</p>

<p>Between 10.5nm ring and the 20nm ring the "BRAVO" begins with varying floors between 3000 or 4000 ft to a height of 7000 ft, the ceiling of the entire "BRAVO"</p>

<p>Beginning at the 8nm ring and the 10.5nm ring, the floor begins at 2000 ft and extends to 7000 ft</p>

<p>From Logan to 8nm, the floor begins at the surface [SFC] and extends to 7,000 ft</p>


<div class="image"><img src="/images/pages/vfr_boundaries.jpeg" /></div>


<p class="caption">Boston Class Bravo Boundaries</p>


<h1>Clearances from KBOS/Class B</h1>

<ul>

    <li>VFR flights are not required to file a flightplan</li>

    <li>The horizontal and vertical limits of the Class B are 20nm to 7,000ft.</li>

    <li>In doing clearances at Logan, you will encounter aircraft who request VFR departures both with and without flightplans.  If the VFR departure request does not have a flightplan, ascertain the type aircraft and intentions for the aircraft's direction of flight and destination. You will encounter VFR departure requests to a direction of flight [Northeast, West] as well as to a destination [KPWM, Mass General, etc]</li>

    <li>Our primary concern with VFR departures is with their direction of flight and what they will do within the Class B.  Once outside the Class B, if the aircraft is leaving, we do not care what the VFR flight does as it will likely not be under air traffic control, [unless the VFR requests Flight Following, see later section on FF]</li>

    <li>Now we either have a VFR flightplan, or we have information from the pilot on his/her intentions in the VFR departure request. We have a few different types of acceptable clearances to provide depending upon the situation you face;</li>


    <ol>

        <li>A helo requests a photoshoot over Fenway park VFR at 1,500. This VFR
            departure will remain within the Tower airspace [8nm/2000ft]. The clearance
            to the helo would be: "[callsign], cleared to operate in the Boston Class
            Bravo airspace to the west at or below 1,500, sq XXXX" The helo then gets
            sent to the Tower for the takeoff clearance.</li>

        <li>An aircraft requests a VFR departure Northeast, has no flightplan, and
            requests 4,500. Air traffic control should advise 4,500 is not a cardinal
            altitude for flight northeast, and recommend 5,500. The controller should
            request the aircrafts destination. If the destination given is within
            the Bravo then the following clearance will be given. If the destination
            is outside of the Bravo airspace then the clearance in example 3 will
            be given. Clearance should be: "[callsign] cleared to operate within the
            Boston Class Bravo Airspace. After Departure maintain VFR at or below
            3,000, departure frequency 133.00, sq XXXX"</li>

        <li>An aircraft requests a VFR departure, filing a flightplan to a destination
            or altitude clearly outside the Bravo. The clearance would be: "[callsign]
            cleared out of the Boston Class Bravo airspace, maintain VFR at or below
            3,000, dep freq 133.00, sq XXXX" In the clearance we are interested only
            in the initial climb, not in the requested cruise altitude as we leave
            that to the TRACON to manage with the pilot and in the context of other
            traffic while in the Bravo.</li>

        <li>VFR departures who request altitudes above 3,000ft that are not appropriate
            for their direction of flight under the NEODD/SWEVEN-VFR rules [cardinal
            altitude +500ft], should have an appropriate altitude recommended by ATC
            but it is not necessary to amend the flightplan, if a flightplan was filed.</li>

        <li>If departure/approach is busy, you may clear an aircraft out of the
            Bravo at or below 2,000ft. to remain below approach airspace. In this
            situation, tower will maintain ownership of the aircraft until clear of the Bravo airspace.</li>

        <li>The local controller will provide a departing VFR aircraft either a
            heading to fly after departure or a traffic pattern exit.</li>

    </ol>

    <li>APP will have the VFR contact handed off to him/her and may vector the aircraft as needed if it is to remain in the Class B dimensions. The controller may need to enter something in the remarks field in the tag. When vectoring, the controller should always advise why the turn is needed. The APP controller provides services as "workload permits" so when the aircraft is 20mi out of the Class B a controller simply terminates radar service. If the pilot requests flight following and it’s a bees nest in and about KBOS approach simple says UNABLE. If not hold the a/c until 40mi or the next APP controller’s or CTR.</li>

</ul>


<h1>Clearance into the Class B</h1>

<ul>

    <li>When a VFR contact calls for clearance into the Class B the pilot may
        want to land at an airport within the Bravo or transit through the airspace.
        This will always be handled by APP or CTR is approach is not on.</li>

    <li>Landing at Logan</li>

    <li>The same steps are taken to radar identify the contact. The aircraft will
        call, "BOS APP Archer 5153L with you at 3500ft 5mi south of Mansfield Airport
        with information ALPHA landing Boston".</li>

    <li>The approach controller will provide a squawk and provide the similar
        greeting to the aircraft not unlike IFR contacts. "Archer 5153L radar contact
        4mi south of the Mansfield Airport you are cleared into the Class BRAVO
        BOS ALT 2997 expect (segment of a traffic pattern. i.e. straight in approach,
        left/right base, left/right downwind) for RWY X remain VFR at all times",
        and issue any altitude or heading required for proper sequencing. As the
        aircraft nears the field the controller may point out the field and provide
        distance and clock position to the field and then handoff to tower when
        appropriate.</li>

    <li>Tower gets the handoff and clears the aircraft to land or clears for the
        option. If the VFR is making multiple approaches the tower can "keep" the
        target and sequence as needed advising the traffic either right or left
        traffic as appropriate.</li>

</ul>


<h1>Landing other fields within Approach’s sector</h1>

<ul>

    <li>The same first steps take place here radar contact and the like. This is where it’s good to have approach charts ready for the underlying airports to have some awareness as to runway configurations. You don’t have to "line the aircraft up" but you do have to ensure it’s pointed in the "right" direction.</li>

    <li>Here comes the tricky part. Once the VFR pilot descends under the floor of the Class B he’s radar services terminated. If the aircraft remains under the floor or s/he is never in the Bravo you only need to provide flight following if requested. Let’s say our Mansfield target is at 2500 and is enroute to KOWD Norwood there is no need for him to be talking to approach as long as s/he stays out of the Bravo. BUT if the pilot requests flight following and the workload permits you can provide it to him/her.</li>

    <li>Landing is the purview of TWR only as an airport outside of Bravo airspace
        without a control tower is considered <a href="controllers/training/tutorial_uncontrolled_airports.php">uncontrolled</a>.
        Give the aircraft the winds and the rest is their concern. You can point
        out the field give distance and clock position and they are on their own.</li>

</ul>


<h1>Transiting through the Class B</h1>

<ul>

    <li>Same first steps here on entering the Class BRAVO. The pilot should call, "BOS APP Warrior 8285B 3mi to the east of Taunton Airport with information ECHO (Boston’s Atis) 3000 ft requesting to transit the CLASS BRAVO enroute Knox County Airport KRKD". The addition of the BOS ATIS is not necessary on the part of the pilot but it lets the controller know that the pilot understands the landing configuration at Logan, so that both are on the same sheet of music.</li>

    <li>Radar contact should go as has been noted above and the aircraft be entered
        into the "NAS". Vectors and traffic calls as needed to ensure separation.
        Radar services terminated out of the BRAVO or leaving my airspace in the
        case of flight following.</li>

</ul>



<h1>Class Bravo Airspace References</h1>

<p><a href="http://www.faa.gov/ATPubs/ATC/Chp7/atc0709.html">http://www.faa.gov/ATPubs/ATC/Chp7/atc0709.html</a></p>

<p><a href="http://www.faa.gov/ATPubs/AIM/Chap3/aim0302.html#3-2-3">http://www.faa.gov/ATPubs/AIM/Chap3/aim0302.html#3-2-3</a></p>


<h2>Class C</h2>

<p>The Class C Airport Tracon [KPVD, KMHT, KPWM, KBTV, KBDL] typically encompasses 30nm around the airport to a height of 10,000ft.</p>

<p>Within this airspace is a "CHARLIE," within which VFR flight operations receive special handling.</p>

<p>In many cases there is a 10mi ring around the Class C with a smaller, 5 mi ring closer to the primary airport which extends from the surface to most often 4000 AGL. An outer ring may have an irregular floor.</p>


<h1>Clearance from Class C Airports</h1>

<ul>

    <li>VFR flights are not required to file a flightplan</li>

    <li>In doing clearances at Class C airports, you will encounter aircraft who
        request VFR departures both with and without flightplans. If the VFR departure
        request does not have a flightplan, ascertain the type aircraft and intentions
        for the aircraft's direction of flight and destination. You will encounter
        VFR departure requests to a direction of flight [Northeast, West] as well
        as to a destination.</li>

    <li>The horizontal and vertical limits of the typical Class C are 10nm to
        4,000ft.</li>
    <li>Clearance to VFR requests for departure is: "[callsign], maintain VFR
        at or below 2,500 (or as adjusted for field elevation), dep freq xxx.xx, sq XXXX" In the clearance we are interested
        only in the initial climb, not in the requested cruise altitude as we leave
        that to the TRACON to manage with the pilot and in the context of other
        traffic.</li>

    <li>You may change the altitude in the initial climb part of the clearance
        if that is appropriate for the VFR departure request.</li>

    <li>You DO NOT cite "cleared out of the Class C" for VFR departures leaving
        the Class C.</li>

    <li>VFR departures who request altitudes above 3,000ft that are not appropriate
        for their direction of flight under the NEODD/SWEVEN-VFR rules [cardinal
        altitude +500ft], should have an appropriate altitude recommended by ATC
        but it is not necessary to amend the flightplan, if a flightplan was filed.</li>

    <li>The local controller will provide either a heading to fly after departure
        or a traffic pattern exit.</li>

</ul>


<h1>Landing at an airport within the Class C</h1>

<ul>

    <li>Most often an aircraft requesting to land at the primary airport within
        the Class C will provide that airport’s ATIS to the approach controller
        and advise him/her that they are inbound for landing. "PVD APP Cessna 179BA
        with information INDIA at 3000 inbound landing PVD".</li>

    <li>"Cessna 179BA PVD APP radar contact 5mi east of the New Bedford airport
        squawk 0345 proceed as requested PVD altimeter 2996." Sequencing, traffic
        alerts and separation should be provided to this target and he should be
        entered into the NAS as noted above. Vectors and the reasons for them should
        be provided to the pilot. Although the 7110.65 does not require controller
        to provide seperation between VFR targets as a matter or course based on
        work load they do.</li>

    <li>An approach controller at a class C TRACON may provide tower services
        for the underlying class C airport.</li>

</ul>


<h1>Landing at an airport within the APPROACH sector / Transiting Flight following</h1>

<ul>

    <li>Same radar contact rules apply to each aircraft and entering into the NAS. The controller will provide VFR advisories like weather and altimeter settings at the intended destination. There is no requirement to line up the aircraft on the approach to the airport. The controller can provide distance to the field and clock position. Most often this service will be associated with flight following. When the pilot advises he has the field in sight the controller will advise to squawk VFR and switch to advisory frequency (in the case of uncontrolled fields) or contact the local controller.</li>

    <li>Transiting the CLASS C and flight following work the same way as the CLASS B with radar contact entering the target into the NAS. Radar service is terminated outside of the airspace or handed off to another controller. </li>

</ul>


<h1>Class Charlie Airspace References</h1>

<p><a href="http://www.faa.gov/ATPubs/ATC/Chp7/atc0708.html">http://www.faa.gov/ATPubs/ATC/Chp7/atc0708.html</a></p>
<p><a href="http://www.faa.gov/ATPubs/AIM/Chap3/aim0302.html#3-2-4">http://www.faa.gov/ATPubs/AIM/Chap3/aim0302.html#3-2-4</a></p>

@stop
