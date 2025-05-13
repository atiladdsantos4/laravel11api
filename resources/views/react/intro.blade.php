@extends('template',["react" => "1"])
@section('title', 'React Intro')
@section('content')
<!-- Content Wrap -->
<div class="w3-col l10 m12" id="main">
      <div id="mainLeaderboard" style="overflow:hidden;">
        <!-- MainLeaderboard-->
      </div>

<h1>React Introduction</h1>
<div class="w3-clear nextprev">
<a class="w3-left w3-btn" href="default.asp">❮ Previous</a>
<a class="w3-right w3-btn" href="react_getstarted.asp">Next ❯</a>
</div>

<hr>
<h2>What is React?</h2>

<p>React is a front-end JavaScript library.</p>
<p>React was developed by the Facebook Software Engineer Jordan Walke.</p>
<p>React is also known as React.js or ReactJS.</p>
<p>React is a tool for building UI components.</p>

<hr>

<h2>How does React Work?</h2>

<div class="w3-panel ws-note">
<p>React creates a VIRTUAL DOM in memory.</p>
</div>

<p>Instead of manipulating the browser's DOM directly, React creates a virtual 
DOM in memory, where it does all the necessary manipulating, before making the 
changes in the browser DOM.</p>
<div class="w3-panel ws-note">
<p>React only changes what needs to be changed!</p>
</div>
<p>React finds out what changes have been 
made, and changes <strong>only</strong> 
what needs to be changed. </p>

<p>You will learn the various aspects of how React does this in the rest of this 
tutorial.</p>

<hr>

<h2>What You Should Already Know</h2>
<p>Before you continue you should have a basic understanding of the following:</p>
<ul>
  <li><a href="/html/default.asp">HTML</a></li>
  <li><a href="/css/default.asp">CSS</a></li>
  <li><a href="/js/default.asp">JavaScript</a></li>
</ul>
<p>If you want to study these subjects first, find the tutorials on our
<a href="/default.asp">Home page</a>.</p>
<hr>

<h2>React.JS History</h2>
<p>Latest version of React.JS is 19.0.0 (December 2024).</p>
<p>Initial release to the Public (version 0.3.0) was in July 2013.</p>
<p>React.JS was first used in 2011 for Facebook's Newsfeed feature. </p>
<p>Facebook Software Engineer, Jordan Walke, created it.</p>

<hr>


</div>
-->
@endsection
        