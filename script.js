document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    const openSidebar = document.getElementById('openSidebar');

    openSidebar.addEventListener('click', function(e) {
        e.preventDefault();
        sidebar.style.left = '0';
        overlay.style.display = 'block';
    });

    overlay.addEventListener('click', function() {
        sidebar.style.left = '-250px';
        overlay.style.display = 'none';
    });
});