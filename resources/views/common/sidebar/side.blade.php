@section('sidebar')
    <!-- Sidebar -->
    <ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('home')}}">
            <div class="sidebar-brand-icon">
                <img src="{{asset('/admin/images/school.png')}}">
            </div>
            <div class="sidebar-brand-text mx-3"></div>
        </a>
        <hr class="sidebar-divider my-0">
        <li class="nav-item active">
            <a class="nav-link" href="{{route('home')}}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
        </li>
        <hr class="sidebar-divider">
        <div class="sidebar-heading">
            Features
        </div>
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBootstrap"
               aria-expanded="true" aria-controls="collapseBootstrap">
                <i class="far fa-fw fa-window-maximize"></i>
                <span>Client</span>
            </a>
            <div id="collapseBootstrap" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item disabled" disabled="true">Cancellation Requests</a>
                </div>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUser"
               aria-expanded="true" aria-controls="collapseUser">
                <i class="fas fa-user-circle"></i>
                <span>User</span>
            </a>
            <div id="collapseUser" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a href="{{route('view-user')}}" class="collapse-item" >View User</a>
                </div>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseParticipant"
               aria-expanded="true" aria-controls="collapseParticipant">
                <i class="fas fa-user-circle"></i>
                <span>Participant</span>
            </a>
            <div id="collapseParticipant" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a href="{{route('view-user')}}" class="collapse-item" >View Participant</a>
                    <a href="{{route('view-user')}}" class="collapse-item" >Pending Participant</a>
                    <a href="{{route('view-user')}}" class="collapse-item" >Final Participant List</a>
                </div>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseEvent"
               aria-expanded="true" aria-controls="collapseEvent">
                <i class="fas fa-user-circle"></i>
                <span>Event</span>
            </a>
            <div id="collapseEvent" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a href="{{route('view-user')}}" class="collapse-item" >Event List</a>
                    <a href="{{route('view-gallery')}}" class="collapse-item" >Photo Gallery</a>
                </div>
            </div>
        </li>

        <hr class="sidebar-divider">
        <div class="sidebar-heading">
            Utilities and Setup
        </div>
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePage" aria-expanded="true"
               aria-controls="collapsePage">
                <i class="fas fa-fw fa-columns"></i>
                <span>Utilities</span>
            </a>
            <div id="collapsePage" class="collapse" aria-labelledby="headingPage" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Utilities</h6>
                    <a class="collapse-item" href="{{route('view-downloads')}}">Downloads</a>
                    <a class="collapse-item" href="{{route('view-content')}}">Content</a>
                </div>
            </div>
        </li>

        <hr class="sidebar-divider">
        <div class="version" id="version-ruangadmin"></div>
    </ul>
    <!-- Sidebar -->

@endsection
