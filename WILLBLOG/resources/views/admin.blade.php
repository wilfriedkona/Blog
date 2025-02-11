<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="{{ asset('css/admin.css')}}" rel="stylesheet">
</head>
<body>
    <div class="sidebar">
        <a href="#" class="logo">
          <img src="{{ asset('image/blog.png')}}" alt="" width="120" height="150">
        </a>
        <ul>
            <li><a href="#">Dashboard</a></li>
            <li><a href="#">Users</a></li>
            <li><a href="#">Posts</a></li>
            <li><a href="#">Reports</a></li>
        </ul>
    </div>
    <div class="content">
        <div class="header">
            <h1>Users Management</h1>

            <a href="{{ route('connect') }}">
            <button class="btn-add" >Retour à la Page d'accueil</button></a>

            <button class="btn-add" onclick="openAddUserModal()">Add User</button>

                        <!-- Modal Add User -->
<div id="addUserModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeAddUserModal()">&times;</span>
        <h2 class="modal-title">Add User</h2>
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" placeholder="Enter Name" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter Email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter Password" required>
            </div>
            <div class="form-group">
                <label for="gender">Genre</label>
                <select id="gender" name="gender" required>
                    <option value="homme">Homme</option>
                    <option value="femme">Femme</option>
                </select>
            </div>
            <div class="form-group">
                <label for="age">Age</label>
                <input type="number" id="age" name="age" placeholder="Enter Age" min="13" max="35" required>
            </div>
             <div class="form-group">
                <label for="role">Role</label>
                <select id="role" name="role" required>
                    <option value="0">User</option>
                    <option value="1">Admin</option>
                </select>
            </div>
            <button type="submit" class="btn-submit">Add User</button>
        </form>
    </div>
</div>

        </div>
        <table class="user-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Genre</th>
                    <th>Age</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="userTableBody">
                <!-- Les données utilisateurs -->
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->gender }}</td>
                        <td>{{ $user->age }}</td>
                        <td>{{ $user->role ? 'Admin' : 'User' }}</td>
                        <td>


                            <!-- Boutons pour les actions admin -->
                            <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}" style="display: inline;" onsubmit="return confirmDeletion(event)">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete">Delete</button>
                            </form>


                            <button class="btn-edit" onclick="openEditUserModal('{{ $user->id }}')">Edit</button>
                            

                                               <!-- Modal Edit User -->
                             <div id="editUserModal{{ $user->id }}" class="modal" style="display: none;">
                                  <div class="modal-content">
                                    <span class="close" onclick="closeEditUserModal('{{ $user->id }}')">&times;</span>
                                       <h2 class="modal-title">Edit User</h2>
                                    <form id="editUserForm{{ $user->id }}" method="POST" action="{{ route('admin.users.update', $user->id) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                      <label for="editName">Name:</label>
                                      <input type="text" id="editName{{ $user->id }}" name="name" value="{{ $user->name }}" required>
                                    </div>

                                    <div class="form-group">
                                      <label for="editEmail">Email:</label>
                                      <input type="email" id="editEmail{{ $user->id }}" name="email" value="{{ $user->email }}" required>
                                    </div>

                                    <div class="form-group">
                                      <label for="editGender">Genre:</label>
                                      <select id="editGender{{ $user->id }}" name="gender" required>
                                        <option value="homme" {{ $user->genre == 'homme' ? 'selected' : '' }}>Homme</option>
                                        <option value="femme" {{ $user->genre == 'femme' ? 'selected' : '' }}>Femme</option>
                                      </select>
                                    </div>

                                    <div class="form-group">
                                       <label for="editAge">Age:</label>
                                       <input type="number" id="editAge{{ $user->id }}" name="age" value="{{ $user->age }}" min="13" max="35" required>
                                    </div>

                                     <div class="form-group">
                                        <label for="editRole">Role:</label>
                                        <select id="editRole{{ $user->id }}" name="role" required>
                                            <option value="0" {{ $user->role == 0 ? 'selected' : '' }}>User</option>
                                            <option value="1" {{ $user->role == 1 ? 'selected' : '' }}>Admin</option>
                                        </select>
                                    </div>

                                    <button type="submit" class="btn-submit">Enrégistrer les modifications</button>
                                </form>
                            </Vdiv>
                        </div>

                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>

    <script>
    // Modal Add User
function openAddUserModal() {
  document.getElementById("addUserModal").style.display = "block";
}

function closeAddUserModal() {
  document.getElementById("addUserModal").style.display = "none";
}

// Modal Edit User
function openEditUserModal(userId) {
  document.getElementById(`editUserModal${userId}`).style.display = "block";
}

function closeEditUserModal(userId) {
  document.getElementById(`editUserModal${userId}`).style.display = "none";
}

// Confirmation de suppression (facultatif)
function confirmDeletion(event) {
  if (!confirm("Êtes-vous sûr de vouloir supprimer cet utilisateur ?")) {
    event.preventDefault(); // Annule la soumission du formulaire
  }
  return true;
}
</script>

</body>
</html>