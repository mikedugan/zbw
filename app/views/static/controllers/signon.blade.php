@extends('layouts.master')
@section('title')
Sign On/Off Policy
@stop
@section('content')
<h3>Sign On/Off and Position Relief Policy</h3>

<h4>Non-Active Positions:</h4>
<p>All vZBW Controllers signing onto the network in a non-active position shall use the prefix “ZBW” in their callsign.</p>
<ul><p>
<li>Examples: ZBW_ATM/ZBW_EE_INS/ZBW_DB_MTR/ZBW_PB_OBS</li></ul>
<p>Active controlling positions shall use current vZBW formats (BOS_CTR/BOS_APP/SYR_TWR/PVD_GND/BGR_DEL, etc.)</p>

<h4>Signing on:</h4>
<span class="text_underline">All vZBW Controllers signing onto the network in an active controlling capacity are required to:</span>
<ol>
<li><p>Check with the senior controller present (APP/CTR/Senior Staff) before signing in to see if they are required at another position.</li></p>

<li><p>Control at the position they are signing on to for a minimum of 30 minutes.</li>
<strong>NOTE: This clause may be waived by the senior controller present, if it is shown to be operationally advantageous to have the controller at a different position.</strong></p>

<li><p>Announce the activation of their position including any relevant operational information (ATIS, Freq, etc.).</li>
<strong>NOTE: Controllers opening either a TRACON or CTR position must announce opening on the ATC channel also. DEL/GND/TWR positions shall not use the ATC channel and announce opening through private chat with their surrounding controllers</strong></p>

<li><p>Ensure that all controller info and any relevant ATIS information is correct and up to date.</li></p>
</ol>

<h4>Signing off:</h4>
<span class="text_underline">All vZBW Controllers signing off from an active controlling position are required to:</span>
<ol>
<li>Provide 15, then 10, then 5, then 2 minutes warning to their surrounding controllers that they are signing off. Once acknowledgement has been received from the surrounding controllers, all other warnings can be omitted and the closing notice is all that is required.</li>
<strong>NOTE: Controllers closing either a TRACON or CTR position must announce a 15 minute warning and closing on the ATC channel also. DEL/GND/TWR positions shall not use the ATC channel and announce closing through private chat with their surrounding controllers</strong></p>

<li><p>Ensure that all surrounding controllers are aware they are signing off.</li></p>

<li><p>Ensure that any controller assuming responsibility for their airspace has been provided a full traffic and airspace brief in that area. Controllers must not sign off without providing an adequate briefing, containing all relevant information about operations within the airspace and the controller assuming responsibility has acknowledged as such.
(i.e. Tower signing off, Approach control remaining. Tower must ensure a full brief has been given to the Approach controller. Approach must acknowledge the brief. Approach signing off, Center control remaining. Approach must ensure a full brief has been given to the Center controller. Center must acknowledge the brief.)
</li></p>
<li><p>Provide a minimum of 5 minutes warning to all pilots on their freq through text and voice that they are signing off.</li></p>
</ol>

<h4>Position Relief:</h4>
<span class="text_underline">All vZBW Controllers signing onto the network to relieve an active controlling position are required to:</span>
<ol>
<li><p>Sign on to the relief position at least 5 minutes before assuming responsibility for said position.</li></p>

<li><p>Ensure that they have been provided a full traffic and airspace brief of the area they will be controlling and acknowledge such brief to the previous controller.
</li></p>
</ol>
@stop
