<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/profile/show.css') }}">

    <title>User Profile</title>
</head>

<body>
    {{-- Profile Picture Modal --}}
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Profile Picture</h5>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> <!-- Close icon -->
                    </button>
                </div>
                <div class="modal-body d-flex justify-content-center">
                    <div class="profile-pic">
                        @if ($user->picture)
                            <img src="{{ asset('images/profiles/' . $user->picture) }}" alt="Profile Picture"
                                class="img-fluid">
                        @else
                            <img src="{{ asset('images/no-prof-pic.png') }}" alt="Profile Picture" class="img-fluid">
                        @endif
                    </div>

                </div>

                <div class="modal-footer d-flex justify-content-between">
                    <form action="{{ route('profile.update', Auth::user()->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="custom-file-input">
                            <label for="picture" class="file-input-label btn btn-primary">
                                Choose file: <span id="fileName"></span>
                                <input type="file" name="picture" id="picture" class="d-none">
                            </label>
                        </div>
                        <div>
                            <input type="submit" class="btn btn-success mt-2" value="Upload">
                        </div>
                    </form>

                    <form action="{{ route('profile.removePic', $user) }}" method="post">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash"></i> <!-- Delete icon -->
                        </button>
                    </form>
                </div>



            </div>
        </div>
    </div>


    @include('layouts.header')
    <div class="main-body-container">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>

            </div>
        @endif


        <div class="container mt-5">
            <!-- User profile picture and name -->
            <div class="d-flex align-items-center">
                <div class="me-3">
                    @if ($user->picture)
                        <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal">
                            <img src="{{ asset('images/profiles/' . $user->picture) }}" alt="Profile Picture"
                                class="profile-picture-modal img-thumbnail rounded-circle">
                        </a>
                    @else
                        <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal">
                            <img src="{{ asset('images/no-prof-pic.png') }}" alt="Profile Picture"
                                class="profile-picture-modal img-thumbnail rounded-circle">
                        </a>
                    @endif
                </div>
                <div>
                    <h2>
                        {{ $user->name }}
                        @if ($user->is_admin)
                            <span class="badge bg-primary">Admin</span>
                        @endif
                    </h2>

                    <p>{{ $user->email }}</p>
                </div>
            </div>

            <!-- User details -->
            <div class="row mt-4">
                <div class="col-md-12">
                    <h3>Details</h3>
                    <form action="{{ route('profile.update', $user) }}" method="post">
                        @csrf
                        @method('PUT')
                        <table class="table table-striped">
                            <tbody>
                                <tr data-field="name">
                                    <th scope="row">Name</th>
                                    <td>{{ $user->name }}</td>
                                </tr>
                                <tr data-field="email">
                                    <th scope="row">Email</th>
                                    <td>{{ $user->email }}</td>
                                </tr>
                                <tr data-field="phone">
                                    <th scope="row">Phone</th>
                                    <td>{{ $user->phone }}</td>
                                </tr>
                                <tr data-field="address">
                                    <th scope="row">Address</th>
                                    <td>{{ $user->address }}</td>
                                </tr>
                            </tbody>
                        </table>

                        <button type="submit" class="btn btn-success" id="update-button">Update</button>
                        <button type="button" class="btn btn-primary" id="edit-button">Edit Details</button>
                        <button type="button" class="btn btn-danger" id="cancel-button">Cancel</button>

                    </form>
                    <form action="{{ route('user.destroy', $user) }}" method="post"
                        onsubmit="return confirm('Are you sure you want to delete your account?\nAll orders will be canceled!')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" id="delete-button">Delete Account</button>
                    </form>

                 </div>
            </div>

        </div>

    </div>
    @include('layouts.footer')
    <script src="{{ asset('js/profile/edit-details.js') }}"></script>
    <script src="{{ asset('js/profile/profile-pic.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>

</body>

</html>
