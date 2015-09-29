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
            <p>Chronomodel is an open source project. You can download the source code and compile everything yourself from scratch.</p>
            <p>
                Chronomodel is hosted on <a href="https://github.com/Chronomodel/chronomodel" target="_blank">GitHub.com</a>. You can clone the repository by typing :
                <pre>git clone https://github.com/Chronomodel/chronomodel.git</pre>
            </p>
            <p>Chronomodel is built on <a href="http://qt-project.org/" target="_blank">Qt 5</a> and uses <a href="http://www.fftw.org/" target="_blank">FFTW library</a>.
                The only pre-requisite to build the software is to have Qt 5 installed on your system.</p>
            <p>We provide pre-compiled binary versions of the latest version of the application for convenience :</p>

            <table class="table table-stripped table-bordered">
                <tr>
                    <th colspan="2">Chronomodel 1.1</th>
                </tr>
                <tr>
                    <td><img src="images/platforms/mac.png" height="50">Mac OS X 10.9 Mavericks, 10.10 Yosemite</td>
                    <td class="but-cell">
                        <!-- - - - - - - - - - - - - - - - - - - - - - - - - - -->
                        <!-- IMPORTANT : ne pas oublier "os" et "version", ainsi que la class "download-btn" -->
                        <!-- - - - - - - - - - - - - - - - - - - - - - - - - - -->
                        <a class="btn btn-primary btn-block download-btn" version="1.1" os="mac">
                            <span class="glyphicon glyphicon-download"></span> Download
                        </a>
                    </td>
                </tr>
                <tr>
                    <td><img src="images/platforms/windows.png" height="50">Windows 32 bits (XP, Vista, 7, 8)</td>
                    <td>
                        <!-- - - - - - - - - - - - - - - - - - - - - - - - - - -->
                        <!-- IMPORTANT : ne pas oublier "os" et "version", ainsi que la class "download-btn" -->
                        <!-- - - - - - - - - - - - - - - - - - - - - - - - - - -->
                        <a class="btn btn-primary btn-block download-btn" version="1.1" os="win">
                            <span class="glyphicon glyphicon-download"></span> Download
                        </a>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <!-- - - - - - - - - - - - - - - - - - - - - - - - - - -->
    <!-- Un slide par nouvelle version, détaillant les problèmes résolus et restants -->
    <!-- - - - - - - - - - - - - - - - - - - - - - - - - - -->
    <div class="slide slide-dwl-1">
        <div class="container">

            <p>
                <h4>Fixed on version 1.1</h4>
                <ul>
                    <li>Search field added on the events scene.</li>
                    <li>When exporting the model's data as CSV, data are grouped by event and comments with event names are added in the CSV file.</li>
                    <li>FFTW library version for Mac downgraded from 3.3.4 to 3.2.2 to ensure Mac OS X 10.7 support.</li>
                    <li>PNG image size can is 4 times bigger than screen resolution.</li>
                    <li>In results view, when browsing by phases, you can now also display data under phases and events by unfolding the results.</li>
                    <li>Duration graph added for phases.</li>
                    <li>CSV import : comments in CSV source file are now displayed in Chronomodel's user interface.</li>
                    <li>When drag-and-dropping data from CSV import to the scene, the data name is used as the newly created event's name.</li>
                    <li>Better event merge, solving a bug that occured sometimes when merging...</li>
                    <li>Graph data export fixed on posterior densities.</li>
                    <li>Calculation issues for models using bounds solved.</li>
                    <li>HPD multi-intervals displayed with their respective percentage.</li>
                    <li>Calculations improvements.</li>
                </ul>
            </p>

            <p>
                <h4>Known issues</h4>
                <ul>
                    <li>There is calculation problem using a "Wiggle Matching" of type "Range" on C14 data.</li>
                    <li>The red square on the model overview tool may appear shifted from its real position and thus not correspond exactly to the currently viewed area. This happens on large models only.</li>
                    <li>If a warning appears during calculations : simply relaunch it. This limitation is due to a numerical overflow when dealing with extreme values. We are currently working on a fix!</li>
                </ul>
            </p>
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


