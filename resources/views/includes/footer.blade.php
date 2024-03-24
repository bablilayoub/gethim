    <!-- Reset Data Modal -->
    <dialog id="reset_data_modal" class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg">Reset Data</h3>
            <p class="py-4"> Are you sure you want to reset all data ?</p>
            <p class="text-sm text-red-500">This action is irreversible and will delete all
                shortened links and their statistics.</p>
            <div class="modal-action">
                <form method="dialog">
                    <button class="btn">Close</button>
                </form>
                <a href="/logout" class="btn btn-error">Reset</a>
            </div>
        </div>
    </dialog>
    <!-- Themes Modal -->
    <dialog id="themes_modal" class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg">Change Theme</h3>
            <p class="py-4"> Select a theme from the list below.</p>
            <select id="theme_select" class="select select-bordered w-full">
                <option value="light">Light</option>
                <option value="dark">Dark</option>
                <option value="cupcake">Cupcake</option>
                <option value="bumblebee">Bumblebee</option>
                <option value="emerald">Emerald</option>
                <option value="corporate">Corporate</option>
                <option value="synthwave">Synthwave</option>
                <option value="retro">Retro</option>
                <option value="cyberpunk">Cyberpunk</option>
                <option value="valentine">Valentine</option>
                <option value="halloween">Halloween</option>
                <option value="garden">Garden</option>
                <option value="forest">Forest</option>
                <option value="aqua">Aqua</option>
                <option value="lofi">Lofi</option>
                <option value="pastel">Pastel</option>
                <option value="fantasy">Fantasy</option>
                <option value="wireframe">Wireframe</option>
                <option value="black">Black</option>
                <option value="luxury">Luxury</option>
                <option value="dracula">Dracula</option>
                <option value="cymk">Cymk</option>
                <option value="autumn">Autumn</option>
                <option value="business">Business</option>
                <option value="acid">Acid</option>
                <option value="lemonade">Lemonade</option>
                <option value="night">Night</option>
                <option value="coffee">Coffee</option>
                <option value="winter">Winter</option>
                <option value="dim">Dim</option>
                <option value="nord">Nord</option>
                <option value="sunset">Sunset</option>
            </select>
            <div class="modal-action">
                <form method="dialog">
                    <button class="btn">Close</button>
                </form>
                <button class="btn btn-primary" onclick="changeTheme()">Change</button>
            </div>
        </div>
    </dialog>
    <!-- Delete Link Modal -->
    <dialog id="delete_link_modal" class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg">Delete Link</h3>
            <p class="py-4"> Are you sure you want to delete this link ?</p>
            <p class="text-sm text-red-500">This action is irreversible and will delete all
                statistics associated with this link.</p>
            <div class="modal-action">
                <form method="dialog">
                    <button class="btn">Close</button>
                </form>
                <button id="delete_link" class="btn btn-error">Delete</button>
            </div>
        </div>
    </dialog>
    <!-- View stats Modal -->
    <dialog id="view_stats_modal" class="modal">
        <div class="modal-box w-11/12 max-w-2xl">
            <h3 class="font-bold text-lg">Link Statistics</h3>
            <p class="py-4"> Here are the statistics for this link, including the number of clicks and
                the location of the visitors.</p>
            <div class="overflow-x-auto w-full" id="stats_table">
                <table class="table table-zebra bg-base-100 text-base-content">
                    <thead>
                        <tr>
                            <th>Ip Address</th>
                            <th>User Agent</th>
                            <th>Time</th>
                            <th>Location</th>
                        </tr>
                    </thead>
                    <tbody id="analytics_table">
                    </tbody>
                </table>
            </div>
            <div id="no_stats" class="alert alert-warning mt-4">
                No statistics available for this link.
            </div>
            <div class="modal-action">
                <form method="dialog">
                    <button class="btn">Close</button>
                </form>
            </div>
        </div>
    </dialog>

@if (session('error') || session('success'))
    <div class="toast toast-start" id="toast">
        @if (session('success'))
            <div class="alert alert-success" role="alert">{{ session('success') }}</div>
        @else
            <div class="alert alert-error" role="alert">{{ session('error') }}</div>
        @endif
    </div>
@endif
<script src="{{ asset('js/app.js') }}"></script>

</body>

</html>
