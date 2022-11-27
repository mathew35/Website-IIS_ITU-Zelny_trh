function profile_view() {
    if (get_profile == null) {
        get_profile = setInterval(get_own, 5000, 'profile', 'get_profile.php');
    }
    console.log("profile");
    console.log(sessionStorage.getItem('profile'));
}