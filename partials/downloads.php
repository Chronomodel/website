<?php

$version_ok = true;

?>


<div id="downloads">

    <div class="slide slide-intro">
        <div class="container">
            <h1>Downloads</h1>
        </div>
    </div>

    <!-- - - - - - - - - - - - - - - - - - - - - - - - - - -->
    <!-- Slide principal avec les téléchargments -->
    <!-- - - - - - - - - - - - - - - - - - - - - - - - - - -->
    <div class="slide slide-dwl-2">
        <div class="container">

            <h2>Get source code</h2>
            <p>
                Chronomodel is an open source project.
                You can download the source code and compile everything yourself from scratch.
                It is built on <a href="http://qt-project.org/" target="_blank">Qt 5</a> and uses <a href="http://www.fftw.org/" target="_blank">FFTW library</a>.
                The only pre-requisite to build it yourself is to have Qt 5 installed on your system.
                The project is hosted on <a href="https://github.com/Chronomodel/chronomodel" target="_blank">GitHub.com</a>. You can clone the repository by typing :
                <pre>git clone https://github.com/Chronomodel/chronomodel.git</pre>
            </p>

            <h2>Download latest version</h2>
            <p>For convenience, we provide pre-compiled binaries of the latest version of the application :</p>
            <?php if($version_ok): ?>
            <div class="download-item">
                <div class="row">
                    <div class="col-sm-8">
                        <div class="title">Chronomodel 1.5 for Mac OS X (March 2016)</div>
                        <div class="subtitle">Supported : 10.7 (Lion), 10.8 (Mountain Lion), 10.9 (Mavericks), 10.10 (Yosemite), 10.11 (El Capitan)</div>
                    </div>
                    <div class="col-sm-4">
                        <!-- - - - - - - - - - - - - - - - - - - - - - - - - - -->
                        <!-- IMPORTANT : ne pas oublier "os" et "version", ainsi que la class "download-btn" -->
                        <!-- - - - - - - - - - - - - - - - - - - - - - - - - - -->
                        <a class="download-btn" version="1.5" os="mac">
                            <!--span class="glyphicon glyphicon-download"></span--> Download
                        </a>
                    </div>
                </div>
            </div>
            <div class="download-item">
                <div class="row">
                    <div class="col-sm-8">
                        <div class="title">Chronomodel 1.5 for Windows 32 bits (March 2016)</div>
                        <div class="subtitle">Supported : Windows 7, Windows 8, Windows 10</div>
                    </div>
                    <div class="col-sm-4">
                        <!-- - - - - - - - - - - - - - - - - - - - - - - - - - -->
                        <!-- IMPORTANT : ne pas oublier "os" et "version", ainsi que la class "download-btn" -->
                        <!-- - - - - - - - - - - - - - - - - - - - - - - - - - -->
                        <a class="download-btn" version="1.5" os="win">
                            <!--span class="glyphicon glyphicon-download"></span--> Download
                        </a>
                    </div>
                </div>
            </div>

            <h2>Download older versions</h2>
            <p>Old published versions of Chronomodel are provided here. 
            <br>
            <?php endif; ?>
            For a full list of releases and pre-releases, please visit 
            <a href="https://github.com/Chronomodel/chronomodel/releases" target="_blank">our "Releases" page on GitHub</a>.</p>
            <div class="download-item">
                <div class="row">
                    <div class="col-sm-8">
                        <div class="title">Chronomodel 1.1 for Mac OS X (January 2015)</div>
                        <div class="subtitle">Supported : 10.9 (Mavericks), 10.10 (Yosemite)</div>
                    </div>
                    <div class="col-sm-4">
                        <!-- - - - - - - - - - - - - - - - - - - - - - - - - - -->
                        <!-- IMPORTANT : ne pas oublier "os" et "version", ainsi que la class "download-btn" -->
                        <!-- - - - - - - - - - - - - - - - - - - - - - - - - - -->
                        <a class="download-btn" version="1.1" os="mac">
                            <!--span class="glyphicon glyphicon-download"></span--> Download
                        </a>
                    </div>
                </div>
            </div>
            <div class="download-item">
                <div class="row">
                    <div class="col-sm-8">
                        <div class="title">Chronomodel 1.1 for Windows 32 bits (January 2015)</div>
                        <div class="subtitle">Supported : Windows XP, Windows Vista, Windows 7, Windows 8</div>
                    </div>
                    <div class="col-sm-4">
                        <!-- - - - - - - - - - - - - - - - - - - - - - - - - - -->
                        <!-- IMPORTANT : ne pas oublier "os" et "version", ainsi que la class "download-btn" -->
                        <!-- - - - - - - - - - - - - - - - - - - - - - - - - - -->
                        <a class="download-btn" version="1.1" os="win">
                            <!--span class="glyphicon glyphicon-download"></span--> Download
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- - - - - - - - - - - - - - - - - - - - - - - - - - -->
    <!-- Un slide par nouvelle version, détaillant les problèmes résolus et restants -->
    <!-- - - - - - - - - - - - - - - - - - - - - - - - - - -->
    <div class="slide slide-dwl-1">
        <div class="container">

        <h2>Release Notes</h2>

        <?php if(true): ?>
        <div class="release-notes">
            <div class="title">
                <i class="glyphicon glyphicon-chevron-right"></i>
                <i class="glyphicon glyphicon-chevron-down"></i>
                Version 1.5
            </div>
            <div class="content">
                <h4>New Features</h4>
                <ul>
                    <li>Individual Dates can be evaluated outside the study period but the curves of posterior are plotted on the study period).</li>
                    <li>Calibration view shows "out of bounds" regions if calibrated density is outside study period.</li>
                    <li>Data are marked as "not computable" if the calibration process gives no result on the whole reference curve definition
		    (whatever the study period).</li>
                    <li>Memory usage improvement.</li>
                    <li>MCMC : All events and data methods can be reset to their default values from the "MCMC" Menu.</li>
                    <li>MCMC settings : New "Mixing Level" parameter. This is related to the ability to find solutions outside study period for dates.</li>
                    <li>Settings Dialog (Preferences) : New dialog layout combining app settings and data method settings.</li>
		    <li>Application Settings (Preferences) : "Language" fixes the decimal separator "." or "," depending on the country. For instance French ',' and UK '.' </li>
                    <li>Application Settings (Preferences) : new image export parameters to control pixel, ratio, dpm and compression factor (quality).</li>
                    <li>Application Settings (Preferences) :  date/time formats  can be BC/AD, CalBP, Cal B2K for displaying  Results and Calibration Views.                         WARNING : The modelling (Study Period and stratigraphic constraints) is always in BC/AD !</li>
                    <li>Data Method Settings (Preferences) : Reference curves can be added or deleted for 14C, Gauss and AM.</li>
                    <li>New "Actions" menu in menu bar to perform grouped actions on selected events (change name, color, method).</li>
                    <li>Un-zooming on events scene hides calibrated dates' thumbnail AND bounds thumbnail.</li>
                    <li>Search box on event's scene is shown only if overview is visible.</li>
                    <li>Data Method Gauss : now possible to use custom curves!</li>
                    <li>General layout improved.</li>
                    <li>"CTRl-c" and "Esc" keyboards shortcuts can toggle Calibration window.</li>
                    <li>Results view : "Fill opacity" can be controled.</li>
                    <li>Results view : Better text log for numerical results.</li>
                    <li>Results view : CSV exports improved with all history plots and numerical results</li>
                    <li>Many other minor improvements ! (<a href="https://github.com/Chronomodel/chronomodel/commits/master" target="_blank">see commits on GitHub for more details</a>)</li>
                </ul>
                <h4>Bugs fixed</h4>
                <ul>
                    <li>"About" dialog can be closed correctly.</li>
                    <li>When quitting, the app asks to save the current project only once.</li>
                    <li>MCMC doesn't crash anymore when cancelling dialog progress box.</li>
                </ul>
                <h4>Known issues</h4>
                <ul>
                    <li>Running MCMC on large models can freeze the application on computers with not enough RAM (Random Access Memory). The MCMC process goes all the way to the end on most cases but the results cannot be displayed because graphical representations are memory consumming. We currently work on a new architecture of the code to solve this issue.</li>
                    <li>The red rectangle corresponding to the zoom on the scene overview can appear shifted on large models.</li>
                    <li>Using pixel ratio > 1 in export image preferences could scale text fonts unappropriatly (depends on platforms)</li>
                    <li>Many improvements on graphs display and zooming performances (nothing "visible" though...)</li>
                    <li>Event properties' view layout improved with better enable/disable states of controls.</li>
                    <li>Data Method Gauss : using the "equation" mode with first parameter not null (the t^2 factor) can break the calibration display on large study period : Y scale is very large and cannot be displayed correctly.</li>
                </ul>
            </div>
        </div>
        <?php endif; ?>
        
        <div class="release-notes">
            <div class="title">
                <i class="glyphicon glyphicon-chevron-right"></i>
                <i class="glyphicon glyphicon-chevron-down"></i>
                Version 1.1
            </div>
            <div class="content">
                <h4>New Features</h4>
                <ul>
                    <li>Search field added on the events scene.</li>
                    <li>When exporting the model's data as CSV, data are grouped by event and comments with event names are added in the CSV file.</li>
                    <li>FFTW library version for Mac downgraded from 3.3.4 to 3.2.2 to ensure Mac OS X 10.7 support.</li>
                    <li>PNG image size is 4 times bigger than screen resolution.</li>
                    <li>In results view, when browsing by phases, you can now also display data under phases and events by unfolding the results.</li>
                    <li>Duration graph added for phases.</li>
                    <li>CSV import : comments in CSV source file are now displayed in Chronomodel's user interface.</li>
                    <li>When drag-and-dropping data from CSV import to the scene, the data name is used as the newly created event's name.</li>
                    <li>HPD multi-intervals displayed with their respective percentage.</li>
                    <li>Calculations improvements.</li>
                </ul>
                <h4>Bug fixes</h4>
                <ul>
                    <li>Better event merge, solving a bug that occured sometimes when merging...</li>
                    <li>Graph data export fixed on posterior densities.</li>
                    <li>Calculation issues for models using bounds solved.</li>
                </ul>
                <h4>Known issues</h4>
                <ul>
                    <li>There is calculation problem using a "Wiggle Matching" of type "Range" on C14 data.</li>
                    <li>The red square on the model overview tool may appear shifted from its real position and thus not correspond exactly to the currently viewed area. This happens on large models only.</li>
                    <li>If a warning appears during calculations : simply relaunch it. This limitation is due to a numerical overflow when dealing with extreme values. We are currently working on a fix!</li>
                </ul>
            </div>
        </div>

    </div>

</div>

<!-- - - - - - - - - - - - - - - - - - - - - - - - - - -->
<!-- Dialogue et formulaire de téléchargement -->
<!-- - - - - - - - - - - - - - - - - - - - - - - - - - -->
<div id="dialog" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Download Chronomodel</h4>
        <p>Please tell us a bit about you so we can provide the best help and support!<br>
        This is not mandatory, and we will not use your personal information in any other purpose.<br>
        You will receive news about updates and new releases (5 to 10 emails a year)!
        </p>
      </div>
      <div class="modal-body">
        <form methd="post" action="download.php" class="">
            <input type="hidden" name="os" id="os" value="">
            <input type="hidden" name="version" id="version" value="">
            <div class="form-group">
                <input type="email" name="email" id="email" class="form-control" placeholder="Your email">
            </div>
            <div class="form-group">
                <input type="text" name="firstname" id="firstname" class="form-control" placeholder="Your firstname">
            </div>
            <div class="form-group">
                <input type="text" name="lastname" id="lastname" class="form-control" placeholder="Your lastname">
            </div>
            <div class="form-group">
                <input type="text" name="organization" id="organization" class="form-control" placeholder="Your organization">
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-sm-6">
                        <button type="button" class="btn btn-default btn-block" data-dismiss="modal">Cancel</button>
                    </div>
                    <div class="col-sm-6">
                        <input type="submit" class="btn btn-primary btn-block" value="Download !">        
                    </div>
                </div>
                
            </div>
        </form>
      </div>
    </div>
  </div>
</div>


