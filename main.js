function toggleDropdown() {
    const dropdownList = document.getElementById('dropdownList');
    const isOpen = dropdownList.classList.contains('open');
    
    if (isOpen) {
      dropdownList.classList.remove('open');
      dropdownList.setAttribute('aria-expanded', 'false');
    } else {
      dropdownList.classList.add('open');
      dropdownList.setAttribute('aria-expanded', 'true');
    }
  }
  
  // Close dropdown when clicking outside
  document.addEventListener('click', function(event) {
    const dropdown = document.querySelector('.dropdown');
    if (!dropdown.contains(event.target)) {
      const dropdownList = document.getElementById('dropdownList');
      dropdownList.classList.remove('open');
      dropdownList.setAttribute('aria-expanded', 'false');
    }
  });