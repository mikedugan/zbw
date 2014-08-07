@extends('layouts.master')
@section('title')
Getting Started
@stop
@section('content')
<h3>Boston ARTCC Airports</h3>

<p>131 airports shown - Click the airport name or ICAO ID for charts and info.</p>

<h2>ZBW airports in class B airspace:</h2>
<table class="table table-bordered">
    <thead>
        <tr>
            <td class="airports-header-cell">ICAO</td>
            <td class="airports-header-cell">Name</td>
            <td class="airports-header-cell">Location</td>
            <td class="airports-header-cell">Class</td>
            <td class="airports-header-cell">TRACON</td>
        </tr>
    <tbody>
    <tr class="airports-primary-cell">
        <td class="airports-primary-cell"><a href="/airports/KBOS">KBOS</A></td>
        <td class="airports-primary-cell"><a href="/airports/KBOS">GENERAL EDWARD LAWRENCE LOGAN INTL</A></td>
        <td class="airports-primary-cell"><nobr>Boston, MA</nobr></td>
        <td class="airports-primary-cell">B</td>
        <td class="airports-primary-cell"><nobr>Boston</nobr></td>
    </tr>
    </tbody>
    </thead>
</table>

<h2>ZBW airports in class C airspace:</h2>

<table class="table table-bordered">
    <thead>
    <tr>
        <td class="airports-header-cell">ICAO</td>
        <td class="airports-header-cell">Name</td>
        <td class="airports-header-cell">Location</td>
        <td class="airports-header-cell">Class</td>
        <td class="airports-header-cell">TRACON</td>
    </tr>
    <tbody>
    <tr class="airports-primary-cell">
        <td class="airports-primary-cell"><a href="/airports/KALB">KALB</A></td>
        <td class="airports-primary-cell"><a href="/airports/KALB">ALBANY INTL</A></td>
        <td class="airports-primary-cell"><nobr>Albany, NY</nobr></td>
        <td class="airports-primary-cell">C</td>
        <td class="airports-primary-cell"><nobr>Albany</nobr></td>
    </tr>


    <tr class="airports-alternate-cell">
        <td class="airports-alternate-cell"><a href="/airports/KBDL">KBDL</A></td>
        <td class="airports-alternate-cell"><a href="/airports/KBDL">BRADLEY INTL</A></td>
        <td class="airports-alternate-cell"><nobr>Windsor Locks, CT</nobr></td>
        <td class="airports-alternate-cell">C</td>
        <td class="airports-alternate-cell"><nobr>Bradley</nobr></td>
    </tr>


    <tr class="airports-primary-cell">
        <td class="airports-primary-cell"><a href="/airports/KBGR">KBGR</A></td>
        <td class="airports-primary-cell"><a href="/airports/KBGR">BANGOR INTL</A></td>
        <td class="airports-primary-cell"><nobr>Bangor, ME</nobr></td>
        <td class="airports-primary-cell">C</td>
        <td class="airports-primary-cell"><nobr>Bangor</nobr></td>
    </tr>


    <tr class="airports-alternate-cell">
        <td class="airports-alternate-cell"><a href="/airports/KBTV">KBTV</A></td>
        <td class="airports-alternate-cell"><a href="/airports/KBTV">BURLINGTON INTL</A></td>
        <td class="airports-alternate-cell"><nobr>Burlington, VT</nobr></td>
        <td class="airports-alternate-cell">C</td>
        <td class="airports-alternate-cell"><nobr>Burlington</nobr></td>
    </tr>


    <tr class="airports-primary-cell">
        <td class="airports-primary-cell"><a href="/airports/KMHT">KMHT</A></td>
        <td class="airports-primary-cell"><a href="/airports/KMHT">MANCHESTER</A></td>
        <td class="airports-primary-cell"><nobr>Manchester, NH</nobr></td>
        <td class="airports-primary-cell">C</td>
        <td class="airports-primary-cell"><nobr>Boston</nobr></td>
    </tr>


    <tr class="airports-alternate-cell">
        <td class="airports-alternate-cell"><a href="/airports/KPVD">KPVD</A></td>
        <td class="airports-alternate-cell"><a href="/airports/KPVD">THEODORE FRANCIS GREEN STATE</A></td>
        <td class="airports-alternate-cell"><nobr>Providence, RI</nobr></td>
        <td class="airports-alternate-cell">C</td>
        <td class="airports-alternate-cell"><nobr>Providence</nobr></td>
    </tr>


    <tr class="airports-primary-cell">
        <td class="airports-primary-cell"><a href="/airports/KPWM">KPWM</A></td>
        <td class="airports-primary-cell"><a href="/airports/KPWM">PORTLAND INTL JETPORT</A></td>
        <td class="airports-primary-cell"><nobr>Portland, ME</nobr></td>
        <td class="airports-primary-cell">C</td>
        <td class="airports-primary-cell"><nobr>Portland</nobr></td>
    </tr>


    <tr class="airports-alternate-cell">
        <td class="airports-alternate-cell"><a href="/airports/KSYR">KSYR</A></td>
        <td class="airports-alternate-cell"><a href="/airports/KSYR">SYRACUSE HANCOCK INTL</A></td>
        <td class="airports-alternate-cell"><nobr>Syracuse, NY</nobr></td>
        <td class="airports-alternate-cell">C</td>
        <td class="airports-alternate-cell"><nobr>Syracuse</nobr></td>
    </tr>
    </tbody>
    </thead>
</table>

<h2>ZBW airports in class D airspace:</h2>
    <table class="table table-bordered">
        <thead>
        <tr>
            <td class="airports-header-cell">ICAO</td>
            <td class="airports-header-cell">Name</td>
            <td class="airports-header-cell">Location</td>
            <td class="airports-header-cell">Class</td>
            <td class="airports-header-cell">TRACON</td>
        </tr>
        <tbody>
        <tr class="airports-primary-cell">
            <td class="airports-primary-cell"><a href="/airports/KACK">KACK</A></td>
            <td class="airports-primary-cell"><a href="/airports/KACK">NANTUCKET MEM</A></td>
            <td class="airports-primary-cell"><nobr>Nantucket, MA</nobr></td>
            <td class="airports-primary-cell">D</td>
            <td class="airports-primary-cell"><nobr>Cape</nobr></td>
        </tr>


        <tr class="airports-alternate-cell">
            <td class="airports-alternate-cell"><a href="/airports/KASH">KASH</A></td>
            <td class="airports-alternate-cell"><a href="/airports/KASH">BOIRE FLD</A></td>
            <td class="airports-alternate-cell"><nobr>Nashua, NH</nobr></td>
            <td class="airports-alternate-cell">D</td>
            <td class="airports-alternate-cell"><nobr>Boston</nobr></td>
        </tr>


        <tr class="airports-primary-cell">
            <td class="airports-primary-cell"><a href="/airports/KBAF">KBAF</A></td>
            <td class="airports-primary-cell"><a href="/airports/KBAF">BARNES MUNI</A></td>
            <td class="airports-primary-cell"><nobr>Westfield, MA</nobr></td>
            <td class="airports-primary-cell">D</td>
            <td class="airports-primary-cell"><nobr>Bradley</nobr></td>
        </tr>


        <tr class="airports-alternate-cell">
            <td class="airports-alternate-cell"><a href="/airports/KBED">KBED</A></td>
            <td class="airports-alternate-cell"><a href="/airports/KBED">LAURENCE G HANSCOM FLD</A></td>
            <td class="airports-alternate-cell"><nobr>Bedford, MA</nobr></td>
            <td class="airports-alternate-cell">D</td>
            <td class="airports-alternate-cell"><nobr>Boston</nobr></td>
        </tr>


        <tr class="airports-primary-cell">
            <td class="airports-primary-cell"><a href="/airports/KBVY">KBVY</A></td>
            <td class="airports-primary-cell"><a href="/airports/KBVY">BEVERLY MUNI</A></td>
            <td class="airports-primary-cell"><nobr>Beverly, MA</nobr></td>
            <td class="airports-primary-cell">D</td>
            <td class="airports-primary-cell"><nobr>Boston</nobr></td>
        </tr>


        <tr class="airports-alternate-cell">
            <td class="airports-alternate-cell"><a href="/airports/KCEF">KCEF</A></td>
            <td class="airports-alternate-cell"><a href="/airports/KCEF">WESTOVER ARB METROPOLITAN</A></td>
            <td class="airports-alternate-cell"><nobr>Springfield/Chicopee, MA</nobr></td>
            <td class="airports-alternate-cell">D</td>
            <td class="airports-alternate-cell"><nobr>Bradley</nobr></td>
        </tr>


        <tr class="airports-primary-cell">
            <td class="airports-primary-cell"><a href="/airports/KEWB">KEWB</A></td>
            <td class="airports-primary-cell"><a href="/airports/KEWB">NEW BEDFORD RGNL</A></td>
            <td class="airports-primary-cell"><nobr>New Bedford, MA</nobr></td>
            <td class="airports-primary-cell">D</td>
            <td class="airports-primary-cell"><nobr>Providence</nobr></td>
        </tr>


        <tr class="airports-alternate-cell">
            <td class="airports-alternate-cell"><a href="/airports/KFMH">KFMH</A></td>
            <td class="airports-alternate-cell"><a href="/airports/KFMH">CAPE COD COAST GUARD AIR STATION</A></td>
            <td class="airports-alternate-cell"><nobr>Falmouth, MA</nobr></td>
            <td class="airports-alternate-cell">D</td>
            <td class="airports-alternate-cell"><nobr>Cape</nobr></td>
        </tr>


        <tr class="airports-primary-cell">
            <td class="airports-primary-cell"><a href="/airports/KGON">KGON</A></td>
            <td class="airports-primary-cell"><a href="/airports/KGON">GROTON NEW LONDON</A></td>
            <td class="airports-primary-cell"><nobr>Groton (New London), CT</nobr></td>
            <td class="airports-primary-cell">D</td>
            <td class="airports-primary-cell"><nobr>Providence</nobr></td>
        </tr>


        <tr class="airports-alternate-cell">
            <td class="airports-alternate-cell"><a href="/airports/KHFD">KHFD</A></td>
            <td class="airports-alternate-cell"><a href="/airports/KHFD">HARTFORD BRAINARD</A></td>
            <td class="airports-alternate-cell"><nobr>Hartford, CT</nobr></td>
            <td class="airports-alternate-cell">D</td>
            <td class="airports-alternate-cell"><nobr>Bradley</nobr></td>
        </tr>


        <tr class="airports-primary-cell">
            <td class="airports-primary-cell"><a href="/airports/KHYA">KHYA</A></td>
            <td class="airports-primary-cell"><a href="/airports/KHYA">BARNSTABLE MUNI BOARDMAN POLANDO FLD</A></td>
            <td class="airports-primary-cell"><nobr>Hyannis, MA</nobr></td>
            <td class="airports-primary-cell">D</td>
            <td class="airports-primary-cell"><nobr>Cape</nobr></td>
        </tr>


        <tr class="airports-alternate-cell">
            <td class="airports-alternate-cell"><a href="/airports/KLEB">KLEB</A></td>
            <td class="airports-alternate-cell"><a href="/airports/KLEB">LEBANON MUNI</A></td>
            <td class="airports-alternate-cell"><nobr>Lebanon, NH</nobr></td>
            <td class="airports-alternate-cell">D</td>
            <td class="airports-alternate-cell"><nobr>N/A</nobr></td>
        </tr>


        <tr class="airports-primary-cell">
            <td class="airports-primary-cell"><a href="/airports/KLWM">KLWM</A></td>
            <td class="airports-primary-cell"><a href="/airports/KLWM">LAWRENCE MUNI</A></td>
            <td class="airports-primary-cell"><nobr>Lawrence, MA</nobr></td>
            <td class="airports-primary-cell">D</td>
            <td class="airports-primary-cell"><nobr>Boston</nobr></td>
        </tr>


        <tr class="airports-alternate-cell">
            <td class="airports-alternate-cell"><a href="/airports/KMVY">KMVY</A></td>
            <td class="airports-alternate-cell"><a href="/airports/KMVY">MARTHAS VINEYARD</A></td>
            <td class="airports-alternate-cell"><nobr>Vineyard Haven, MA</nobr></td>
            <td class="airports-alternate-cell">D</td>
            <td class="airports-alternate-cell"><nobr>Cape</nobr></td>
        </tr>


        <tr class="airports-primary-cell">
            <td class="airports-primary-cell"><a href="/airports/KNHZ">KNHZ</A></td>
            <td class="airports-primary-cell"><a href="/airports/KNHZ">BRUNSWICK NAS (CLOSED PERM)</A></td>
            <td class="airports-primary-cell"><nobr>Brunswick, ME</nobr></td>
            <td class="airports-primary-cell">D</td>
            <td class="airports-primary-cell"><nobr>Brunswick</nobr></td>
        </tr>


        <tr class="airports-alternate-cell">
            <td class="airports-alternate-cell"><a href="/airports/KOQU">KOQU</A></td>
            <td class="airports-alternate-cell"><a href="/airports/KOQU">QUONSET STATE</A></td>
            <td class="airports-alternate-cell"><nobr>North Kingstown, RI</nobr></td>
            <td class="airports-alternate-cell">D</td>
            <td class="airports-alternate-cell"><nobr>Providence</nobr></td>
        </tr>


        <tr class="airports-primary-cell">
            <td class="airports-primary-cell"><a href="/airports/KORH">KORH</A></td>
            <td class="airports-primary-cell"><a href="/airports/KORH">WORCESTER RGNL</A></td>
            <td class="airports-primary-cell"><nobr>Worcester, MA</nobr></td>
            <td class="airports-primary-cell">D</td>
            <td class="airports-primary-cell"><nobr>Bradley</nobr></td>
        </tr>


        <tr class="airports-alternate-cell">
            <td class="airports-alternate-cell"><a href="/airports/KOWD">KOWD</A></td>
            <td class="airports-alternate-cell"><a href="/airports/KOWD">NORWOOD MEM</A></td>
            <td class="airports-alternate-cell"><nobr>Norwood, MA</nobr></td>
            <td class="airports-alternate-cell">D</td>
            <td class="airports-alternate-cell"><nobr>Boston</nobr></td>
        </tr>


        <tr class="airports-primary-cell">
            <td class="airports-primary-cell"><a href="/airports/KPSM">KPSM</A></td>
            <td class="airports-primary-cell"><a href="/airports/KPSM">PEASE INTL TRADEPORT</A></td>
            <td class="airports-primary-cell"><nobr>Portsmouth, NH</nobr></td>
            <td class="airports-primary-cell">D</td>
            <td class="airports-primary-cell"><nobr>Boston</nobr></td>
        </tr>


        <tr class="airports-alternate-cell">
            <td class="airports-alternate-cell"><a href="/airports/KSCH">KSCH</A></td>
            <td class="airports-alternate-cell"><a href="/airports/KSCH">SCHENECTADY CO</A></td>
            <td class="airports-alternate-cell"><nobr>Schenectady, NY</nobr></td>
            <td class="airports-alternate-cell">D</td>
            <td class="airports-alternate-cell"><nobr>Albany</nobr></td>
        </tr>
        </tbody>
        </thead>
    </table>

<h2>ZBW airports in class E airspace:</h2>
    <table class="table table-bordered">
        <thead>
        <tr>
            <td class="airports-header-cell">ICAO</td>
            <td class="airports-header-cell">Name</td>
            <td class="airports-header-cell">Location</td>
            <td class="airports-header-cell">Class</td>
            <td class="airports-header-cell">TRACON</td>
        </tr>
        <tbody>
        <tr class="airports-primary-cell">
            <td class="airports-primary-cell"><a href="/airports/K0B5">K0B5</A></td>
            <td class="airports-primary-cell"><a href="/airports/K0B5">TURNERS FALLS</A></td>
            <td class="airports-primary-cell"><nobr>Montague, MA</nobr></td>
            <td class="airports-primary-cell">E</td>
            <td class="airports-primary-cell"><nobr>N/A</nobr></td>
        </tr>


        <tr class="airports-alternate-cell">
            <td class="airports-alternate-cell"><a href="/airports/K0B8">K0B8</A></td>
            <td class="airports-alternate-cell"><a href="/airports/K0B8">ELIZABETH FLD</A></td>
            <td class="airports-alternate-cell"><nobr>Fishers Island, NY</nobr></td>
            <td class="airports-alternate-cell">E</td>
            <td class="airports-alternate-cell"><nobr>Providence</nobr></td>
        </tr>


        <tr class="airports-primary-cell">
            <td class="airports-primary-cell"><a href="/airports/K0G7">K0G7</A></td>
            <td class="airports-primary-cell"><a href="/airports/K0G7">FINGER LAKES RGNL</A></td>
            <td class="airports-primary-cell"><nobr>Seneca Falls, NY</nobr></td>
            <td class="airports-primary-cell">E</td>
            <td class="airports-primary-cell"><nobr>N/A</nobr></td>
        </tr>


        <tr class="airports-alternate-cell">
            <td class="airports-alternate-cell"><a href="/airports/K1B0">K1B0</A></td>
            <td class="airports-alternate-cell"><a href="/airports/K1B0">DEXTER RGNL</A></td>
            <td class="airports-alternate-cell"><nobr>Dexter, ME</nobr></td>
            <td class="airports-alternate-cell">E</td>
            <td class="airports-alternate-cell"><nobr>Bangor</nobr></td>
        </tr>


        <tr class="airports-primary-cell">
            <td class="airports-primary-cell"><a href="/airports/K1B1">K1B1</A></td>
            <td class="airports-primary-cell"><a href="/airports/K1B1">COLUMBIA CO</A></td>
            <td class="airports-primary-cell"><nobr>Hudson, NY</nobr></td>
            <td class="airports-primary-cell">E</td>
            <td class="airports-primary-cell"><nobr>Albany</nobr></td>
        </tr>


        <tr class="airports-alternate-cell">
            <td class="airports-alternate-cell"><a href="/airports/K1B6">K1B6</A></td>
            <td class="airports-alternate-cell"><a href="/airports/K1B6">HOPEDALE INDUSTRIAL PARK</A></td>
            <td class="airports-alternate-cell"><nobr>Hopedale, MA</nobr></td>
            <td class="airports-alternate-cell">E</td>
            <td class="airports-alternate-cell"><nobr>Bradley</nobr></td>
        </tr>


        <tr class="airports-primary-cell">
            <td class="airports-primary-cell"><a href="/airports/K1B9">K1B9</A></td>
            <td class="airports-primary-cell"><a href="/airports/K1B9">MANSFIELD MUNI</A></td>
            <td class="airports-primary-cell"><nobr>Mansfield, MA</nobr></td>
            <td class="airports-primary-cell">E</td>
            <td class="airports-primary-cell"><nobr>Boston</nobr></td>
        </tr>


        <tr class="airports-alternate-cell">
            <td class="airports-alternate-cell"><a href="/airports/K2B7">K2B7</A></td>
            <td class="airports-alternate-cell"><a href="/airports/K2B7">PITTSFIELD MUNI</A></td>
            <td class="airports-alternate-cell"><nobr>Pittsfield, ME</nobr></td>
            <td class="airports-alternate-cell">E</td>
            <td class="airports-alternate-cell"><nobr>Bangor</nobr></td>
        </tr>


        <tr class="airports-primary-cell">
            <td class="airports-primary-cell"><a href="/airports/K3B0">K3B0</A></td>
            <td class="airports-primary-cell"><a href="/airports/K3B0">SOUTHBRIDGE MUNI</A></td>
            <td class="airports-primary-cell"><nobr>Southbridge, MA</nobr></td>
            <td class="airports-primary-cell">E</td>
            <td class="airports-primary-cell"><nobr>Bradley</nobr></td>
        </tr>


        <tr class="airports-alternate-cell">
            <td class="airports-alternate-cell"><a href="/airports/K3B1">K3B1</A></td>
            <td class="airports-alternate-cell"><a href="/airports/K3B1">GREENVILLE MUNI</A></td>
            <td class="airports-alternate-cell"><nobr>Greenville, ME</nobr></td>
            <td class="airports-alternate-cell">E</td>
            <td class="airports-alternate-cell"><nobr>N/A</nobr></td>
        </tr>


        <tr class="airports-primary-cell">
            <td class="airports-primary-cell"><a href="/airports/K3B2">K3B2</A></td>
            <td class="airports-primary-cell"><a href="/airports/K3B2">MARSHFIELD MUNI GEORGE HARLOW FLD</A></td>
            <td class="airports-primary-cell"><nobr>Marshfield, MA</nobr></td>
            <td class="airports-primary-cell">E</td>
            <td class="airports-primary-cell"><nobr>Boston</nobr></td>
        </tr>


        <tr class="airports-alternate-cell">
            <td class="airports-alternate-cell"><a href="/airports/K3B4">K3B4</A></td>
            <td class="airports-alternate-cell"><a href="/airports/K3B4">LITTLEBROOK AIR PARK</A></td>
            <td class="airports-alternate-cell"><nobr>Eliot, ME</nobr></td>
            <td class="airports-alternate-cell">E</td>
            <td class="airports-alternate-cell"><nobr>Boston</nobr></td>
        </tr>


        <tr class="airports-primary-cell">
            <td class="airports-primary-cell"><a href="/airports/K4B0">K4B0</A></td>
            <td class="airports-primary-cell"><a href="/airports/K4B0">SOUTH ALBANY</A></td>
            <td class="airports-primary-cell"><nobr>South Bethlehem, NY</nobr></td>
            <td class="airports-primary-cell">E</td>
            <td class="airports-primary-cell"><nobr>N/A</nobr></td>
        </tr>


        <tr class="airports-alternate-cell">
            <td class="airports-alternate-cell"><a href="/airports/K4B6">K4B6</A></td>
            <td class="airports-alternate-cell"><a href="/airports/K4B6">TICONDEROGA MUNI</A></td>
            <td class="airports-alternate-cell"><nobr>Ticonderoga, NY</nobr></td>
            <td class="airports-alternate-cell">E</td>
            <td class="airports-alternate-cell"><nobr>N/A</nobr></td>
        </tr>


        <tr class="airports-primary-cell">
            <td class="airports-primary-cell"><a href="/airports/K4V8">K4V8</A></td>
            <td class="airports-primary-cell"><a href="/airports/K4V8">MOUNT SNOW</A></td>
            <td class="airports-primary-cell"><nobr>West Dover, VT</nobr></td>
            <td class="airports-primary-cell">E</td>
            <td class="airports-primary-cell"><nobr>N/A</nobr></td>
        </tr>


        <tr class="airports-alternate-cell">
            <td class="airports-alternate-cell"><a href="/airports/K52B">K52B</A></td>
            <td class="airports-alternate-cell"><a href="/airports/K52B">GREENVILLE SEAPLANE BASE</A></td>
            <td class="airports-alternate-cell"><nobr>Greenville, ME</nobr></td>
            <td class="airports-alternate-cell">E</td>
            <td class="airports-alternate-cell"><nobr>N/A</nobr></td>
        </tr>


        <tr class="airports-primary-cell">
            <td class="airports-primary-cell"><a href="/airports/K5B2">K5B2</A></td>
            <td class="airports-primary-cell"><a href="/airports/K5B2">SARATOGA CO</A></td>
            <td class="airports-primary-cell"><nobr>Saratoga Springs, NY</nobr></td>
            <td class="airports-primary-cell">E</td>
            <td class="airports-primary-cell"><nobr>Albany</nobr></td>
        </tr>


        <tr class="airports-alternate-cell">
            <td class="airports-alternate-cell"><a href="/airports/K5B9">K5B9</A></td>
            <td class="airports-alternate-cell"><a href="/airports/K5B9">DEAN MEMORIAL AIRPORT</A></td>
            <td class="airports-alternate-cell"><nobr>HAVERHILL, NH</nobr></td>
            <td class="airports-alternate-cell">E</td>
            <td class="airports-alternate-cell"><nobr>N/A</nobr></td>
        </tr>


        <tr class="airports-primary-cell">
            <td class="airports-primary-cell"><a href="/airports/K6B6">K6B6</A></td>
            <td class="airports-primary-cell"><a href="/airports/K6B6">MINUTE MAN AIR FIELD</A></td>
            <td class="airports-primary-cell"><nobr>Stow, MA</nobr></td>
            <td class="airports-primary-cell">E</td>
            <td class="airports-primary-cell"><nobr>Boston</nobr></td>
        </tr>


        <tr class="airports-alternate-cell">
            <td class="airports-alternate-cell"><a href="/airports/K6B8">K6B8</A></td>
            <td class="airports-alternate-cell"><a href="/airports/K6B8">CALEDONIA CO</A></td>
            <td class="airports-alternate-cell"><nobr>Lyndonville, VT</nobr></td>
            <td class="airports-alternate-cell">E</td>
            <td class="airports-alternate-cell"><nobr>N/A</nobr></td>
        </tr>


        <tr class="airports-primary-cell">
            <td class="airports-primary-cell"><a href="/airports/K6B9">K6B9</A></td>
            <td class="airports-primary-cell"><a href="/airports/K6B9">SKANEATELES AERO DROME</A></td>
            <td class="airports-primary-cell"><nobr>Skaneateles, NY</nobr></td>
            <td class="airports-primary-cell">E</td>
            <td class="airports-primary-cell"><nobr>Syracuse</nobr></td>
        </tr>


        <tr class="airports-alternate-cell">
            <td class="airports-alternate-cell"><a href="/airports/K7B2">K7B2</A></td>
            <td class="airports-alternate-cell"><a href="/airports/K7B2">NORTHAMPTON</A></td>
            <td class="airports-alternate-cell"><nobr>Northampton, MA</nobr></td>
            <td class="airports-alternate-cell">E</td>
            <td class="airports-alternate-cell"><nobr>Bradley</nobr></td>
        </tr>


        <tr class="airports-primary-cell">
            <td class="airports-primary-cell"><a href="/airports/K81B">K81B</A></td>
            <td class="airports-primary-cell"><a href="/airports/K81B">OXFORD CO RGNL</A></td>
            <td class="airports-primary-cell"><nobr>Oxford, ME</nobr></td>
            <td class="airports-primary-cell">E</td>
            <td class="airports-primary-cell"><nobr>Portland</nobr></td>
        </tr>


        <tr class="airports-alternate-cell">
            <td class="airports-alternate-cell"><a href="/airports/K8B0">K8B0</A></td>
            <td class="airports-alternate-cell"><a href="/airports/K8B0">STEVEN A BEAN MUNI</A></td>
            <td class="airports-alternate-cell"><nobr>Rangeley, ME</nobr></td>
            <td class="airports-alternate-cell">E</td>
            <td class="airports-alternate-cell"><nobr>N/A</nobr></td>
        </tr>


        <tr class="airports-primary-cell">
            <td class="airports-primary-cell"><a href="/airports/KAFN">KAFN</A></td>
            <td class="airports-primary-cell"><a href="/airports/KAFN">JAFFREY ARPT SILVER RANCH</A></td>
            <td class="airports-primary-cell"><nobr>Jaffrey, NH</nobr></td>
            <td class="airports-primary-cell">E</td>
            <td class="airports-primary-cell"><nobr>N/A</nobr></td>
        </tr>


        <tr class="airports-alternate-cell">
            <td class="airports-alternate-cell"><a href="/airports/KART">KART</A></td>
            <td class="airports-alternate-cell"><a href="/airports/KART">WATERTOWN INTL</A></td>
            <td class="airports-alternate-cell"><nobr>Watertown, NY</nobr></td>
            <td class="airports-alternate-cell">E</td>
            <td class="airports-alternate-cell"><nobr>Wheeler-Sack</nobr></td>
        </tr>


        <tr class="airports-primary-cell">
            <td class="airports-primary-cell"><a href="/airports/KAUG">KAUG</A></td>
            <td class="airports-primary-cell"><a href="/airports/KAUG">AUGUSTA STATE</A></td>
            <td class="airports-primary-cell"><nobr>Augusta, ME</nobr></td>
            <td class="airports-primary-cell">E</td>
            <td class="airports-primary-cell"><nobr>Portland</nobr></td>
        </tr>


        <tr class="airports-alternate-cell">
            <td class="airports-alternate-cell"><a href="/airports/KB16">KB16</A></td>
            <td class="airports-alternate-cell"><a href="/airports/KB16">WHITFORDS</A></td>
            <td class="airports-alternate-cell"><nobr>Weedsport, NY</nobr></td>
            <td class="airports-alternate-cell">E</td>
            <td class="airports-alternate-cell"><nobr>Syracuse</nobr></td>
        </tr>


        <tr class="airports-primary-cell">
            <td class="airports-primary-cell"><a href="/airports/KB19">KB19</A></td>
            <td class="airports-primary-cell"><a href="/airports/KB19">BIDDEFORD MUNI</A></td>
            <td class="airports-primary-cell"><nobr>Biddeford, ME</nobr></td>
            <td class="airports-primary-cell">E</td>
            <td class="airports-primary-cell"><nobr>Portland</nobr></td>
        </tr>


        <tr class="airports-alternate-cell">
            <td class="airports-alternate-cell"><a href="/airports/KBHB">KBHB</A></td>
            <td class="airports-alternate-cell"><a href="/airports/KBHB">HANCOCK CO BAR HARBOR</A></td>
            <td class="airports-alternate-cell"><nobr>Bar Harbor, ME</nobr></td>
            <td class="airports-alternate-cell">E</td>
            <td class="airports-alternate-cell"><nobr>Bangor</nobr></td>
        </tr>


        <tr class="airports-primary-cell">
            <td class="airports-primary-cell"><a href="/airports/KBID">KBID</A></td>
            <td class="airports-primary-cell"><a href="/airports/KBID">BLOCK ISLAND STATE</A></td>
            <td class="airports-primary-cell"><nobr>Block Island, RI</nobr></td>
            <td class="airports-primary-cell">E</td>
            <td class="airports-primary-cell"><nobr>Providence</nobr></td>
        </tr>


        <tr class="airports-alternate-cell">
            <td class="airports-alternate-cell"><a href="/airports/KBML">KBML</A></td>
            <td class="airports-alternate-cell"><a href="/airports/KBML">BERLIN MUNI</A></td>
            <td class="airports-alternate-cell"><nobr>Berlin, NH</nobr></td>
            <td class="airports-alternate-cell">E</td>
            <td class="airports-alternate-cell"><nobr>N/A</nobr></td>
        </tr>


        <tr class="airports-primary-cell">
            <td class="airports-primary-cell"><a href="/airports/KBST">KBST</A></td>
            <td class="airports-primary-cell"><a href="/airports/KBST">BELFAST MUNI</A></td>
            <td class="airports-primary-cell"><nobr>Belfast, ME</nobr></td>
            <td class="airports-primary-cell">E</td>
            <td class="airports-primary-cell"><nobr>Bangor</nobr></td>
        </tr>


        <tr class="airports-alternate-cell">
            <td class="airports-alternate-cell"><a href="/airports/KBXM">KBXM</A></td>
            <td class="airports-alternate-cell"><a href="/airports/KBXM">BRUNSWICK EXECUTIVE</A></td>
            <td class="airports-alternate-cell"><nobr>Brunswick, ME</nobr></td>
            <td class="airports-alternate-cell">E</td>
            <td class="airports-alternate-cell"><nobr>Portland</nobr></td>
        </tr>


        <tr class="airports-primary-cell">
            <td class="airports-primary-cell"><a href="/airports/KCAR">KCAR</A></td>
            <td class="airports-primary-cell"><a href="/airports/KCAR">CARIBOU MUNI</A></td>
            <td class="airports-primary-cell"><nobr>Caribou, ME</nobr></td>
            <td class="airports-primary-cell">E</td>
            <td class="airports-primary-cell"><nobr>N/A</nobr></td>
        </tr>


        <tr class="airports-alternate-cell">
            <td class="airports-alternate-cell"><a href="/airports/KCNH">KCNH</A></td>
            <td class="airports-alternate-cell"><a href="/airports/KCNH">CLAREMONT MUNI</A></td>
            <td class="airports-alternate-cell"><nobr>Claremont, NH</nobr></td>
            <td class="airports-alternate-cell">E</td>
            <td class="airports-alternate-cell"><nobr>N/A</nobr></td>
        </tr>


        <tr class="airports-primary-cell">
            <td class="airports-primary-cell"><a href="/airports/KCON">KCON</A></td>
            <td class="airports-primary-cell"><a href="/airports/KCON">CONCORD MUNI</A></td>
            <td class="airports-primary-cell"><nobr>Concord, NH</nobr></td>
            <td class="airports-primary-cell">E</td>
            <td class="airports-primary-cell"><nobr>Boston</nobr></td>
        </tr>


        <tr class="airports-alternate-cell">
            <td class="airports-alternate-cell"><a href="/airports/KCQX">KCQX</A></td>
            <td class="airports-alternate-cell"><a href="/airports/KCQX">CHATHAM MUNI</A></td>
            <td class="airports-alternate-cell"><nobr>Chatham, MA</nobr></td>
            <td class="airports-alternate-cell">E</td>
            <td class="airports-alternate-cell"><nobr>Cape</nobr></td>
        </tr>


        <tr class="airports-primary-cell">
            <td class="airports-primary-cell"><a href="/airports/KDAW">KDAW</A></td>
            <td class="airports-primary-cell"><a href="/airports/KDAW">SKYHAVEN</A></td>
            <td class="airports-primary-cell"><nobr>Rochester, NH</nobr></td>
            <td class="airports-primary-cell">E</td>
            <td class="airports-primary-cell"><nobr>Boston</nobr></td>
        </tr>


        <tr class="airports-alternate-cell">
            <td class="airports-alternate-cell"><a href="/airports/KDDH">KDDH</A></td>
            <td class="airports-alternate-cell"><a href="/airports/KDDH">WILLIAM H MORSE STATE</A></td>
            <td class="airports-alternate-cell"><nobr>Bennington, VT</nobr></td>
            <td class="airports-alternate-cell">E</td>
            <td class="airports-alternate-cell"><nobr>Albany</nobr></td>
        </tr>


        <tr class="airports-primary-cell">
            <td class="airports-primary-cell"><a href="/airports/KEEN">KEEN</A></td>
            <td class="airports-primary-cell"><a href="/airports/KEEN">DILLANT HOPKINS</A></td>
            <td class="airports-primary-cell"><nobr>Keene, NH</nobr></td>
            <td class="airports-primary-cell">E</td>
            <td class="airports-primary-cell"><nobr>N/A</nobr></td>
        </tr>


        <tr class="airports-alternate-cell">
            <td class="airports-alternate-cell"><a href="/airports/KEFK">KEFK</A></td>
            <td class="airports-alternate-cell"><a href="/airports/KEFK">NEWPORT STATE</A></td>
            <td class="airports-alternate-cell"><nobr>Newport, VT</nobr></td>
            <td class="airports-alternate-cell">E</td>
            <td class="airports-alternate-cell"><nobr>N/A</nobr></td>
        </tr>


        <tr class="airports-primary-cell">
            <td class="airports-primary-cell"><a href="/airports/KEPM">KEPM</A></td>
            <td class="airports-primary-cell"><a href="/airports/KEPM">EASTPORT MUNI</A></td>
            <td class="airports-primary-cell"><nobr>Eastport, ME</nobr></td>
            <td class="airports-primary-cell">E</td>
            <td class="airports-primary-cell"><nobr>N/A</nobr></td>
        </tr>


        <tr class="airports-alternate-cell">
            <td class="airports-alternate-cell"><a href="/airports/KFIT">KFIT</A></td>
            <td class="airports-alternate-cell"><a href="/airports/KFIT">FITCHBURG MUNI</A></td>
            <td class="airports-alternate-cell"><nobr>Fitchburg, MA</nobr></td>
            <td class="airports-alternate-cell">E</td>
            <td class="airports-alternate-cell"><nobr>Boston</nobr></td>
        </tr>


        <tr class="airports-primary-cell">
            <td class="airports-primary-cell"><a href="/airports/KFSO">KFSO</A></td>
            <td class="airports-primary-cell"><a href="/airports/KFSO">FRANKLIN CO STATE</A></td>
            <td class="airports-primary-cell"><nobr>Highgate, VT</nobr></td>
            <td class="airports-primary-cell">E</td>
            <td class="airports-primary-cell"><nobr>Burlington</nobr></td>
        </tr>


        <tr class="airports-alternate-cell">
            <td class="airports-alternate-cell"><a href="/airports/KFVE">KFVE</A></td>
            <td class="airports-alternate-cell"><a href="/airports/KFVE">NORTHERN AROOSTOOK RGNL</A></td>
            <td class="airports-alternate-cell"><nobr>Frenchville, ME</nobr></td>
            <td class="airports-alternate-cell">E</td>
            <td class="airports-alternate-cell"><nobr>N/A</nobr></td>
        </tr>


        <tr class="airports-primary-cell">
            <td class="airports-primary-cell"><a href="/airports/KFZY">KFZY</A></td>
            <td class="airports-primary-cell"><a href="/airports/KFZY">OSWEGO CO</A></td>
            <td class="airports-primary-cell"><nobr>Fulton, NY</nobr></td>
            <td class="airports-primary-cell">E</td>
            <td class="airports-primary-cell"><nobr>Syracuse</nobr></td>
        </tr>


        <tr class="airports-alternate-cell">
            <td class="airports-alternate-cell"><a href="/airports/KGBR">KGBR</A></td>
            <td class="airports-alternate-cell"><a href="/airports/KGBR">WALTER J KOLADZA</A></td>
            <td class="airports-alternate-cell"><nobr>Great Barrington, MA</nobr></td>
            <td class="airports-alternate-cell">E</td>
            <td class="airports-alternate-cell"><nobr>Albany</nobr></td>
        </tr>


        <tr class="airports-primary-cell">
            <td class="airports-primary-cell"><a href="/airports/KGDM">KGDM</A></td>
            <td class="airports-primary-cell"><a href="/airports/KGDM">GARDNER MUNI</A></td>
            <td class="airports-primary-cell"><nobr>Gardner, MA</nobr></td>
            <td class="airports-primary-cell">E</td>
            <td class="airports-primary-cell"><nobr>N/A</nobr></td>
        </tr>


        <tr class="airports-alternate-cell">
            <td class="airports-alternate-cell"><a href="/airports/KGFL">KGFL</A></td>
            <td class="airports-alternate-cell"><a href="/airports/KGFL">FLOYD BENNETT MEM</A></td>
            <td class="airports-alternate-cell"><nobr>Glens Falls, NY</nobr></td>
            <td class="airports-alternate-cell">E</td>
            <td class="airports-alternate-cell"><nobr>Albany</nobr></td>
        </tr>


        <tr class="airports-primary-cell">
            <td class="airports-primary-cell"><a href="/airports/KGTB">KGTB</A></td>
            <td class="airports-primary-cell"><a href="/airports/KGTB">WHEELER SACK AAF</A></td>
            <td class="airports-primary-cell"><nobr>Fort Drum, NY</nobr></td>
            <td class="airports-primary-cell">E</td>
            <td class="airports-primary-cell"><nobr>Wheeler-Sack</nobr></td>
        </tr>


        <tr class="airports-alternate-cell">
            <td class="airports-alternate-cell"><a href="/airports/KHIE">KHIE</A></td>
            <td class="airports-alternate-cell"><a href="/airports/KHIE">MOUNT WASHINGTON RGNL</A></td>
            <td class="airports-alternate-cell"><nobr>Whitefield, NH</nobr></td>
            <td class="airports-alternate-cell">E</td>
            <td class="airports-alternate-cell"><nobr>N/A</nobr></td>
        </tr>


        <tr class="airports-primary-cell">
            <td class="airports-primary-cell"><a href="/airports/KHUL">KHUL</A></td>
            <td class="airports-primary-cell"><a href="/airports/KHUL">HOULTON INTL</A></td>
            <td class="airports-primary-cell"><nobr>Houlton, ME</nobr></td>
            <td class="airports-primary-cell">E</td>
            <td class="airports-primary-cell"><nobr>N/A</nobr></td>
        </tr>


        <tr class="airports-alternate-cell">
            <td class="airports-alternate-cell"><a href="/airports/KIJD">KIJD</A></td>
            <td class="airports-alternate-cell"><a href="/airports/KIJD">WINDHAM</A></td>
            <td class="airports-alternate-cell"><nobr>Willimantic, CT</nobr></td>
            <td class="airports-alternate-cell">E</td>
            <td class="airports-alternate-cell"><nobr>Providence</nobr></td>
        </tr>


        <tr class="airports-primary-cell">
            <td class="airports-primary-cell"><a href="/airports/KIWI">KIWI</A></td>
            <td class="airports-primary-cell"><a href="/airports/KIWI">WISCASSET</A></td>
            <td class="airports-primary-cell"><nobr>Wiscasset, ME</nobr></td>
            <td class="airports-primary-cell">E</td>
            <td class="airports-primary-cell"><nobr>Brunswick</nobr></td>
        </tr>


        <tr class="airports-alternate-cell">
            <td class="airports-alternate-cell"><a href="/airports/KIZG">KIZG</A></td>
            <td class="airports-alternate-cell"><a href="/airports/KIZG">EASTERN SLOPES RGNL</A></td>
            <td class="airports-alternate-cell"><nobr>Fryeburg, ME</nobr></td>
            <td class="airports-alternate-cell">E</td>
            <td class="airports-alternate-cell"><nobr>Portland</nobr></td>
        </tr>


        <tr class="airports-primary-cell">
            <td class="airports-primary-cell"><a href="/airports/KLCI">KLCI</A></td>
            <td class="airports-primary-cell"><a href="/airports/KLCI">LACONIA MUNI</A></td>
            <td class="airports-primary-cell"><nobr>Laconia, NH</nobr></td>
            <td class="airports-primary-cell">E</td>
            <td class="airports-primary-cell"><nobr>Boston</nobr></td>
        </tr>


        <tr class="airports-alternate-cell">
            <td class="airports-alternate-cell"><a href="/airports/KLEW">KLEW</A></td>
            <td class="airports-alternate-cell"><a href="/airports/KLEW">AUBURN LEWISTON MUNI</A></td>
            <td class="airports-alternate-cell"><nobr>Auburn-Lewiston, ME</nobr></td>
            <td class="airports-alternate-cell">E</td>
            <td class="airports-alternate-cell"><nobr>Portland</nobr></td>
        </tr>


        <tr class="airports-primary-cell">
            <td class="airports-primary-cell"><a href="/airports/KLKP">KLKP</A></td>
            <td class="airports-primary-cell"><a href="/airports/KLKP">LAKE PLACID</A></td>
            <td class="airports-primary-cell"><nobr>Lake Placid, NY</nobr></td>
            <td class="airports-primary-cell">E</td>
            <td class="airports-primary-cell"><nobr>N/A</nobr></td>
        </tr>


        <tr class="airports-alternate-cell">
            <td class="airports-alternate-cell"><a href="/airports/KLRG">KLRG</A></td>
            <td class="airports-alternate-cell"><a href="/airports/KLRG">LINCOLN RGNL</A></td>
            <td class="airports-alternate-cell"><nobr>Lincoln, ME</nobr></td>
            <td class="airports-alternate-cell">E</td>
            <td class="airports-alternate-cell"><nobr>N/A</nobr></td>
        </tr>


        <tr class="airports-primary-cell">
            <td class="airports-primary-cell"><a href="/airports/KLZD">KLZD</A></td>
            <td class="airports-primary-cell"><a href="/airports/KLZD">DANIELSON</A></td>
            <td class="airports-primary-cell"><nobr>Danielson, CT</nobr></td>
            <td class="airports-primary-cell">E</td>
            <td class="airports-primary-cell"><nobr>Providence</nobr></td>
        </tr>


        <tr class="airports-alternate-cell">
            <td class="airports-alternate-cell"><a href="/airports/KMAL">KMAL</A></td>
            <td class="airports-alternate-cell"><a href="/airports/KMAL">MALONE DUFORT</A></td>
            <td class="airports-alternate-cell"><nobr>Malone, NY</nobr></td>
            <td class="airports-alternate-cell">E</td>
            <td class="airports-alternate-cell"><nobr>N/A</nobr></td>
        </tr>


        <tr class="airports-primary-cell">
            <td class="airports-primary-cell"><a href="/airports/KMLT">KMLT</A></td>
            <td class="airports-primary-cell"><a href="/airports/KMLT">MILLINOCKET MUNI</A></td>
            <td class="airports-primary-cell"><nobr>Millinocket, ME</nobr></td>
            <td class="airports-primary-cell">E</td>
            <td class="airports-primary-cell"><nobr>N/A</nobr></td>
        </tr>


        <tr class="airports-alternate-cell">
            <td class="airports-alternate-cell"><a href="/airports/KMMK">KMMK</A></td>
            <td class="airports-alternate-cell"><a href="/airports/KMMK">MERIDEN MARKHAM MUNI</A></td>
            <td class="airports-alternate-cell"><nobr>Meriden, CT</nobr></td>
            <td class="airports-alternate-cell">E</td>
            <td class="airports-alternate-cell"><nobr>Bradley</nobr></td>
        </tr>


        <tr class="airports-primary-cell">
            <td class="airports-primary-cell"><a href="/airports/KMPV">KMPV</A></td>
            <td class="airports-primary-cell"><a href="/airports/KMPV">EDWARD F KNAPP STATE</A></td>
            <td class="airports-primary-cell"><nobr>Barre-Montpelier, VT</nobr></td>
            <td class="airports-primary-cell">E</td>
            <td class="airports-primary-cell"><nobr>N/A</nobr></td>
        </tr>


        <tr class="airports-alternate-cell">
            <td class="airports-alternate-cell"><a href="/airports/KMSS">KMSS</A></td>
            <td class="airports-alternate-cell"><a href="/airports/KMSS">MASSENA INTL RICHARDS FLD</A></td>
            <td class="airports-alternate-cell"><nobr>Massena, NY</nobr></td>
            <td class="airports-alternate-cell">E</td>
            <td class="airports-alternate-cell"><nobr>N/A</nobr></td>
        </tr>


        <tr class="airports-primary-cell">
            <td class="airports-primary-cell"><a href="/airports/KMTP">KMTP</A></td>
            <td class="airports-primary-cell"><a href="/airports/KMTP">MONTAUK</A></td>
            <td class="airports-primary-cell"><nobr>Montauk, NY</nobr></td>
            <td class="airports-primary-cell">E</td>
            <td class="airports-primary-cell"><nobr>N/A</nobr></td>
        </tr>


        <tr class="airports-alternate-cell">
            <td class="airports-alternate-cell"><a href="/airports/KMVL">KMVL</A></td>
            <td class="airports-alternate-cell"><a href="/airports/KMVL">MORRISVILLE STOWE STATE</A></td>
            <td class="airports-alternate-cell"><nobr>Morrisville, VT</nobr></td>
            <td class="airports-alternate-cell">E</td>
            <td class="airports-alternate-cell"><nobr>N/A</nobr></td>
        </tr>


        <tr class="airports-primary-cell">
            <td class="airports-primary-cell"><a href="/airports/KMVM">KMVM</A></td>
            <td class="airports-primary-cell"><a href="/airports/KMVM">MACHIAS VALLEY</A></td>
            <td class="airports-primary-cell"><nobr>Machias, ME</nobr></td>
            <td class="airports-primary-cell">E</td>
            <td class="airports-primary-cell"><nobr>N/A</nobr></td>
        </tr>


        <tr class="airports-alternate-cell">
            <td class="airports-alternate-cell"><a href="/airports/KN04">KN04</A></td>
            <td class="airports-alternate-cell"><a href="/airports/KN04">GRISWOLD (CLOSED PERM)</A></td>
            <td class="airports-alternate-cell"><nobr>Madison, CT</nobr></td>
            <td class="airports-alternate-cell">E</td>
            <td class="airports-alternate-cell"><nobr>N/A</nobr></td>
        </tr>


        <tr class="airports-primary-cell">
            <td class="airports-primary-cell"><a href="/airports/KN23">KN23</A></td>
            <td class="airports-primary-cell"><a href="/airports/KN23">SIDNEY MUNI</A></td>
            <td class="airports-primary-cell"><nobr>Sidney, NY</nobr></td>
            <td class="airports-primary-cell">E</td>
            <td class="airports-primary-cell"><nobr>N/A</nobr></td>
        </tr>


        <tr class="airports-alternate-cell">
            <td class="airports-alternate-cell"><a href="/airports/KN66">KN66</A></td>
            <td class="airports-alternate-cell"><a href="/airports/KN66">ONEONTA MUNI</A></td>
            <td class="airports-alternate-cell"><nobr>Oneonta, NY</nobr></td>
            <td class="airports-alternate-cell">E</td>
            <td class="airports-alternate-cell"><nobr>N/A</nobr></td>
        </tr>


        <tr class="airports-primary-cell">
            <td class="airports-primary-cell"><a href="/airports/KNY0">KNY0</A></td>
            <td class="airports-primary-cell"><a href="/airports/KNY0">FULTON CO</A></td>
            <td class="airports-primary-cell"><nobr>Johnstown, NY</nobr></td>
            <td class="airports-primary-cell">E</td>
            <td class="airports-primary-cell"><nobr>Albany</nobr></td>
        </tr>


        <tr class="airports-alternate-cell">
            <td class="airports-alternate-cell"><a href="/airports/KOGS">KOGS</A></td>
            <td class="airports-alternate-cell"><a href="/airports/KOGS">OGDENSBURG INTL</A></td>
            <td class="airports-alternate-cell"><nobr>Ogdensburg, NY</nobr></td>
            <td class="airports-alternate-cell">E</td>
            <td class="airports-alternate-cell"><nobr>N/A</nobr></td>
        </tr>


        <tr class="airports-primary-cell">
            <td class="airports-primary-cell"><a href="/airports/KOIC">KOIC</A></td>
            <td class="airports-primary-cell"><a href="/airports/KOIC">LT WARREN EATON</A></td>
            <td class="airports-primary-cell"><nobr>Norwich, NY</nobr></td>
            <td class="airports-primary-cell">E</td>
            <td class="airports-primary-cell"><nobr>N/A</nobr></td>
        </tr>


        <tr class="airports-alternate-cell">
            <td class="airports-alternate-cell"><a href="/airports/KOLD">KOLD</A></td>
            <td class="airports-alternate-cell"><a href="/airports/KOLD">DEWITT FLD OLD TOWN MUNI</A></td>
            <td class="airports-alternate-cell"><nobr>Old Town, ME</nobr></td>
            <td class="airports-alternate-cell">E</td>
            <td class="airports-alternate-cell"><nobr>Bangor</nobr></td>
        </tr>


        <tr class="airports-primary-cell">
            <td class="airports-primary-cell"><a href="/airports/KORE">KORE</A></td>
            <td class="airports-primary-cell"><a href="/airports/KORE">ORANGE MUNI</A></td>
            <td class="airports-primary-cell"><nobr>Orange, MA</nobr></td>
            <td class="airports-primary-cell">E</td>
            <td class="airports-primary-cell"><nobr>N/A</nobr></td>
        </tr>


        <tr class="airports-alternate-cell">
            <td class="airports-alternate-cell"><a href="/airports/KOWK">KOWK</A></td>
            <td class="airports-alternate-cell"><a href="/airports/KOWK">CENTRAL MAINE OF NORRIDGEWOCK</A></td>
            <td class="airports-alternate-cell"><nobr>Norridgewock, ME</nobr></td>
            <td class="airports-alternate-cell">E</td>
            <td class="airports-alternate-cell"><nobr>Portland</nobr></td>
        </tr>


        <tr class="airports-primary-cell">
            <td class="airports-primary-cell"><a href="/airports/KOXC">KOXC</A></td>
            <td class="airports-primary-cell"><a href="/airports/KOXC">WATERBURY OXFORD</A></td>
            <td class="airports-primary-cell"><nobr>Oxford, CT</nobr></td>
            <td class="airports-primary-cell">E</td>
            <td class="airports-primary-cell"><nobr>N/A</nobr></td>
        </tr>


        <tr class="airports-alternate-cell">
            <td class="airports-alternate-cell"><a href="/airports/KPBG">KPBG</A></td>
            <td class="airports-alternate-cell"><a href="/airports/KPBG">PLATTSBURGH INTL</A></td>
            <td class="airports-alternate-cell"><nobr>Plattsburgh, NY</nobr></td>
            <td class="airports-alternate-cell">E</td>
            <td class="airports-alternate-cell"><nobr>Burlington</nobr></td>
        </tr>


        <tr class="airports-primary-cell">
            <td class="airports-primary-cell"><a href="/airports/KPLB">KPLB</A></td>
            <td class="airports-primary-cell"><a href="/airports/KPLB">CLINTON CO</A></td>
            <td class="airports-primary-cell"><nobr>Plattsburgh, NY</nobr></td>
            <td class="airports-primary-cell">E</td>
            <td class="airports-primary-cell"><nobr>Burlington</nobr></td>
        </tr>


        <tr class="airports-alternate-cell">
            <td class="airports-alternate-cell"><a href="/airports/KPNN">KPNN</A></td>
            <td class="airports-alternate-cell"><a href="/airports/KPNN">PRINCETON MUNI</A></td>
            <td class="airports-alternate-cell"><nobr>Princeton, ME</nobr></td>
            <td class="airports-alternate-cell">E</td>
            <td class="airports-alternate-cell"><nobr>N/A</nobr></td>
        </tr>


        <tr class="airports-primary-cell">
            <td class="airports-primary-cell"><a href="/airports/KPQI">KPQI</A></td>
            <td class="airports-primary-cell"><a href="/airports/KPQI">NORTHERN MAINE RGNL AT PRESQUE ISLE</A></td>
            <td class="airports-primary-cell"><nobr>Presque Isle, ME</nobr></td>
            <td class="airports-primary-cell">E</td>
            <td class="airports-primary-cell"><nobr>N/A</nobr></td>
        </tr>


        <tr class="airports-alternate-cell">
            <td class="airports-alternate-cell"><a href="/airports/KPSF">KPSF</A></td>
            <td class="airports-alternate-cell"><a href="/airports/KPSF">PITTSFIELD MUNI</A></td>
            <td class="airports-alternate-cell"><nobr>Pittsfield, MA</nobr></td>
            <td class="airports-alternate-cell">E</td>
            <td class="airports-alternate-cell"><nobr>Albany</nobr></td>
        </tr>


        <tr class="airports-primary-cell">
            <td class="airports-primary-cell"><a href="/airports/KPTD">KPTD</A></td>
            <td class="airports-primary-cell"><a href="/airports/KPTD">POTSDAM MUNI</A></td>
            <td class="airports-primary-cell"><nobr>Potsdam, NY</nobr></td>
            <td class="airports-primary-cell">E</td>
            <td class="airports-primary-cell"><nobr>N/A</nobr></td>
        </tr>


        <tr class="airports-alternate-cell">
            <td class="airports-alternate-cell"><a href="/airports/KPVC">KPVC</A></td>
            <td class="airports-alternate-cell"><a href="/airports/KPVC">PROVINCETOWN MUNI</A></td>
            <td class="airports-alternate-cell"><nobr>Provincetown, MA</nobr></td>
            <td class="airports-alternate-cell">E</td>
            <td class="airports-alternate-cell"><nobr>Cape</nobr></td>
        </tr>


        <tr class="airports-primary-cell">
            <td class="airports-primary-cell"><a href="/airports/KPYM">KPYM</A></td>
            <td class="airports-primary-cell"><a href="/airports/KPYM">PLYMOUTH MUNI</A></td>
            <td class="airports-primary-cell"><nobr>Plymouth, MA</nobr></td>
            <td class="airports-primary-cell">E</td>
            <td class="airports-primary-cell"><nobr>Cape</nobr></td>
        </tr>


        <tr class="airports-alternate-cell">
            <td class="airports-alternate-cell"><a href="/airports/KRKD">KRKD</A></td>
            <td class="airports-alternate-cell"><a href="/airports/KRKD">KNOX CO RGNL</A></td>
            <td class="airports-alternate-cell"><nobr>Rockland, ME</nobr></td>
            <td class="airports-alternate-cell">E</td>
            <td class="airports-alternate-cell"><nobr>Brunswick</nobr></td>
        </tr>


        <tr class="airports-primary-cell">
            <td class="airports-primary-cell"><a href="/airports/KRME">KRME</A></td>
            <td class="airports-primary-cell"><a href="/airports/KRME">GRIFFISS AIRPARK</A></td>
            <td class="airports-primary-cell"><nobr>Rome, NY</nobr></td>
            <td class="airports-primary-cell">E</td>
            <td class="airports-primary-cell"><nobr>Griffiss</nobr></td>
        </tr>


        <tr class="airports-alternate-cell">
            <td class="airports-alternate-cell"><a href="/airports/KRUT">KRUT</A></td>
            <td class="airports-alternate-cell"><a href="/airports/KRUT">RUTLAND STATE</A></td>
            <td class="airports-alternate-cell"><nobr>Rutland, VT</nobr></td>
            <td class="airports-alternate-cell">E</td>
            <td class="airports-alternate-cell"><nobr>N/A</nobr></td>
        </tr>


        <tr class="airports-primary-cell">
            <td class="airports-primary-cell"><a href="/airports/KSFM">KSFM</A></td>
            <td class="airports-primary-cell"><a href="/airports/KSFM">SANFORD RGNL</A></td>
            <td class="airports-primary-cell"><nobr>Sanford, ME</nobr></td>
            <td class="airports-primary-cell">E</td>
            <td class="airports-primary-cell"><nobr>Portland</nobr></td>
        </tr>


        <tr class="airports-alternate-cell">
            <td class="airports-alternate-cell"><a href="/airports/KSFZ">KSFZ</A></td>
            <td class="airports-alternate-cell"><a href="/airports/KSFZ">NORTH CENTRAL STATE</A></td>
            <td class="airports-alternate-cell"><nobr>Pawtucket, RI</nobr></td>
            <td class="airports-alternate-cell">E</td>
            <td class="airports-alternate-cell"><nobr>Providence</nobr></td>
        </tr>


        <tr class="airports-primary-cell">
            <td class="airports-primary-cell"><a href="/airports/KSLK">KSLK</A></td>
            <td class="airports-primary-cell"><a href="/airports/KSLK">ADIRONDACK RGNL</A></td>
            <td class="airports-primary-cell"><nobr>Saranac Lake, NY</nobr></td>
            <td class="airports-primary-cell">E</td>
            <td class="airports-primary-cell"><nobr>N/A</nobr></td>
        </tr>


        <tr class="airports-alternate-cell">
            <td class="airports-alternate-cell"><a href="/airports/KTAN">KTAN</A></td>
            <td class="airports-alternate-cell"><a href="/airports/KTAN">TAUNTON MUNI</A></td>
            <td class="airports-alternate-cell"><nobr>Taunton, MA</nobr></td>
            <td class="airports-alternate-cell">E</td>
            <td class="airports-alternate-cell"><nobr>Providence</nobr></td>
        </tr>


        <tr class="airports-primary-cell">
            <td class="airports-primary-cell"><a href="/airports/KUUU">KUUU</A></td>
            <td class="airports-primary-cell"><a href="/airports/KUUU">NEWPORT STATE</A></td>
            <td class="airports-primary-cell"><nobr>Newport, RI</nobr></td>
            <td class="airports-primary-cell">E</td>
            <td class="airports-primary-cell"><nobr>Providence</nobr></td>
        </tr>


        <tr class="airports-alternate-cell">
            <td class="airports-alternate-cell"><a href="/airports/KVGC">KVGC</A></td>
            <td class="airports-alternate-cell"><a href="/airports/KVGC">HAMILTON MUNI (formerly H30)</A></td>
            <td class="airports-alternate-cell"><nobr>Hamilton, NY</nobr></td>
            <td class="airports-alternate-cell">E</td>
            <td class="airports-alternate-cell"><nobr>Syracuse</nobr></td>
        </tr>


        <tr class="airports-primary-cell">
            <td class="airports-primary-cell"><a href="/airports/KVSF">KVSF</A></td>
            <td class="airports-primary-cell"><a href="/airports/KVSF">HARTNESS STATE</A></td>
            <td class="airports-primary-cell"><nobr>Springfield, VT</nobr></td>
            <td class="airports-primary-cell">E</td>
            <td class="airports-primary-cell"><nobr>N/A</nobr></td>
        </tr>


        <tr class="airports-alternate-cell">
            <td class="airports-alternate-cell"><a href="/airports/KWST">KWST</A></td>
            <td class="airports-alternate-cell"><a href="/airports/KWST">WESTERLY STATE</A></td>
            <td class="airports-alternate-cell"><nobr>Westerly, RI</nobr></td>
            <td class="airports-alternate-cell">E</td>
            <td class="airports-alternate-cell"><nobr>Providence</nobr></td>
        </tr>


        <tr class="airports-primary-cell">
            <td class="airports-primary-cell"><a href="/airports/KWVL">KWVL</A></td>
            <td class="airports-primary-cell"><a href="/airports/KWVL">WATERVILLE ROBERT LAFLEUR</A></td>
            <td class="airports-primary-cell"><nobr>Waterville, ME</nobr></td>
            <td class="airports-primary-cell">E</td>
            <td class="airports-primary-cell"><nobr>Portland</nobr></td>
        </tr>
        </tbody>
        </thead>
    </table>
@stop
