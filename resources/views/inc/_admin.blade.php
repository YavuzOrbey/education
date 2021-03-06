<div class="side-menu">
    <aside class="menu">
        <p class="menu-label">General</p>
        <ul class="menu-list">
        <li><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
        </ul>
        <p class="menu-label">Subjects</p>
        <ul class="menu-list">
            <li><a href="{{route('subjects.create')}}">Create</a></li>
        </ul>
        <p class="menu-label">Assignments</p>
        <ul class="menu-list">
            <li><a href="{{route('assignments.create')}}">Create</a></li>
            <li><a href="{{route('assignments.manage')}}">Manage Assignments</a></li>
            <li><a href="{{route('assignments.insert')}}">Insert Book Questions</a></li>
        </ul>

        <p class="menu-label">Questions</p>
        <ul class="menu-list">
            <li><a href="{{route('book_questions.create')}}">Create New Book Question</a></li>
            <li><a href="{{route('questions.create')}}">Create New Question</a></li>
        </ul>

        <p class="menu-label">Users</p>
        <ul class="menu-list">
            <li><a href="{{route('admin.users.index')}}">List</a></li>
        </ul>
    </aside>
    
</div>