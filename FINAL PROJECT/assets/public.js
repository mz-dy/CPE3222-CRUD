//  USC Sign-In

async function lookupUser() {
  const idField     = document.getElementById('usc_id_lookup');
  const id          = idField.value.trim();
  const statusBox   = document.getElementById('usc_statusBox');
  const formFields  = document.getElementById('usc_formFields');
  const actionBox   = document.getElementById('usc_actionBox');
  const signInBtn   = document.getElementById('usc_signInBtn');
  const signOutBtn  = document.getElementById('usc_signOutBtn');
  const registerBtn = document.getElementById('usc_registerBtn');

  if (!id) {
    statusBox.innerHTML = '<div class="alert alert-error">Please enter an ID number first.</div>';
    formFields.classList.add('hide');
    actionBox.classList.add('hide');
    return;
  }

  document.getElementById('usc_id').value = id;
  document.getElementById('usc_id_display').value = id;

  statusBox.innerHTML = '<div class="alert alert-info">Checking record...</div>';

  /*const res  = await fetch('api/lookup.php?usc_id=' + encodeURIComponent(id));
  const data = await res.json();

  if (data.ok && data.user) {
    uscFillForm(data.user);
    uscSetReadonly(true);
    statusBox.innerHTML = '<div class="alert alert-success">Record found. Please verify your details before signing in or out.</div>';
    formFields.classList.remove('hide');
    actionBox.classList.remove('hide');
    registerBtn.classList.add('hide');
    signInBtn.classList.remove('hide');
    signOutBtn.classList.remove('hide');
  } else {
    uscClearForm();
    uscSetReadonly(false);
    statusBox.innerHTML = '<div class="alert alert-info">No previous record found. Please complete the registration form.</div>';
    formFields.classList.remove('hide');
    actionBox.classList.remove('hide');
    registerBtn.classList.remove('hide');
    signInBtn.classList.add('hide');
    signOutBtn.classList.add('hide');
  }*/
 if (id === '123') {          /* TEST CASE ONLY */
    const user = {
      usc_id: '123',
      first_name: 'Juan',
      middle_name: 'D.',
      last_name: 'Cruz',
      barangay: 'Lahug',
      city: 'Cebu City',
      province: 'Cebu',
      contact_number: '09123456789',
      email: 'juan@example.com'
    };

    uscFillForm(user);
    uscSetReadonly(true);
    statusBox.innerHTML = '<div class="alert alert-success">Record found. Please verify your details before signing in or out.</div>';
    formFields.classList.remove('hide');
    actionBox.classList.remove('hide');
    registerBtn.classList.add('hide');
    signInBtn.classList.remove('hide');
    signOutBtn.classList.remove('hide');
    statusBox.innerHTML = '<div class="alert alert-success">Record found (TEST MODE)</div>';
  } else {
    uscClearForm();
    uscSetReadonly(false);
    statusBox.innerHTML = '<div class="alert alert-info">No previous record found. Please complete the registration form.</div>';
    formFields.classList.remove('hide');
    actionBox.classList.remove('hide');
    registerBtn.classList.remove('hide');
    signInBtn.classList.add('hide');
    signOutBtn.classList.add('hide');
  }
}

function uscFillForm(user) {
  const fields = ['first_name', 'middle_name', 'last_name','barangay','city','province','contact_number','email'];
  fields.forEach(k => {
    const el = document.getElementById('usc_' + k);
    if (el) el.value = user[k] || '';
  });
  const display = document.getElementById('usc_id_display');
  if (display) display.value = user.usc_id || '';
}

function uscClearForm() {
  const fields = ['first_name', 'middle_name', 'last_name','barangay','city','province','contact_number','email'];
  fields.forEach(k => {
    const el = document.getElementById('usc_' + k);
    if (el) el.value = '';
  });
}

function uscSetReadonly(readonly) {
  const fields = ['first_name', 'middle_name', 'last_name','barangay','city','province','contact_number','email'];
  fields.forEach(k => {
    const el = document.getElementById('usc_' + k);
    if (el) el.readOnly = readonly;
  });
}

function uscPrepareAction(action) {
  const actionField = document.getElementById('usc_action');
  if (actionField) actionField.value = action;
  return true;
}

// doc listener
document.addEventListener('DOMContentLoaded', () => {
  /*const uscForm = document.getElementById('uscTraceForm');
  if (uscForm) {
    uscForm.addEventListener('submit', function (e) {
      const id = document.getElementById('usc_id_display').value.trim();
      if (!id) {
        alert('ID number is required for Faculty, Staff, or Student.');
        e.preventDefault();
      }
    });
  }*/

  // Sync id_display with lookup input
  const lookup  = document.getElementById('usc_id_lookup');
  const display = document.getElementById('usc_id_display');
  if (lookup && display) {
    lookup.addEventListener('input', () => {
      display.value = lookup.value;
    });
  }

  // "New User?" register link
  const registerLink = document.getElementById('registerLink');
  if (registerLink) {
    registerLink.addEventListener('click', (e) => {
      e.preventDefault();
      document.getElementById('usc_formFields').classList.remove('hide');
      document.getElementById('usc_actionBox').classList.remove('hide');
      document.getElementById('usc_registerBtn').classList.remove('hide');
      document.getElementById('usc_signInBtn').classList.add('hide');
      document.getElementById('usc_signOutBtn').classList.add('hide');
      uscSetReadonly(false);
    });
  }

  // "New Guest?" register link
  const g_registerLink = document.getElementById('guest_registerLink');
  if (g_registerLink) {
    guest_registerLink.addEventListener('click', (e) => {
      e.preventDefault();
      document.getElementById('guest_formFields').classList.remove('hide');
      document.getElementById('guest_actionBox').classList.remove('hide');
      document.getElementById('guest_registerBtn').classList.remove('hide');
      document.getElementById('guest_signInBtn').classList.add('hide');
      document.getElementById('guest_signOutBtn').classList.add('hide');
      guestSetReadonly(false);
    });
  }
});


// Guest Sign-In 

async function lookupGuest() {
  const fname      = document.getElementById('guest_fname_lookup').value.trim();
  const mname      = document.getElementById('guest_mname_lookup').value.trim();
  const lname      = document.getElementById('guest_lname_lookup').value.trim();
  const statusBox  = document.getElementById('guest_statusBox');
  const formFields = document.getElementById('guest_formFields');
  const actionBox  = document.getElementById('guest_actionBox');
  const signInBtn  = document.getElementById('guest_signInBtn');
  const signOutBtn = document.getElementById('guest_signOutBtn');
  const registerBtn= document.getElementById('guest_registerBtn');

  if (!fname || !lname || !mname) {
    statusBox.innerHTML = '<div class="alert alert-error">Please enter all name fields.</div>';
    formFields.classList.add('hide');
    actionBox.classList.add('hide');
    return;
  }

  document.getElementById('guest_first_name').value = fname;
  document.getElementById('guest_middle_name').value = mname;
  document.getElementById('guest_last_name').value = lname;
  document.getElementById('guest_fname_display').value = fname;
  document.getElementById('guest_mname_display').value = mname;
  document.getElementById('guest_lname_display').value = lname;
  statusBox.innerHTML = '<div class="alert alert-info">Checking record...</div>';

  /*const res  = await fetch(
    'api/lookup.php?first_name=' + encodeURIComponent(fname) +
    '&last_name='                + encodeURIComponent(lname) +
    '&user_type=Guest'
  );
  const data = await res.json();

  if (data.ok && data.user) {
    guestFillForm(data.user);
    guestSetReadonly(true);
    statusBox.innerHTML = '<div class="alert alert-success">Record found. Please verify your details before signing in or out.</div>';
    formFields.classList.remove('hide');
    actionBox.classList.remove('hide');
    registerBtn.classList.add('hide');
    signInBtn.classList.remove('hide');
    signOutBtn.classList.remove('hide');
  } else {
    guestClearForm();
    guestSetReadonly(false);
    // Pre-fill name fields from what was typed
    const fnEl = document.getElementById('guest_first_name');
    const lnEl = document.getElementById('guest_last_name');
    if (fnEl) fnEl.value = fname;
    if (lnEl) lnEl.value = lname;
    statusBox.innerHTML = '<div class="alert alert-info">No previous record found. Please complete the registration form.</div>';
    formFields.classList.remove('hide');
    actionBox.classList.remove('hide');
    registerBtn.classList.remove('hide');
    signInBtn.classList.add('hide');
    signOutBtn.classList.add('hide');
  }*/
 if (fname === 'Juan' && mname === 'De' && lname === 'Cruz') {
    const user = {
      usc_id: '',
      first_name: 'Juan',
      middle_name: 'De',
      last_name: 'Cruz',
      barangay: 'Lahug',
      city: 'Cebu City',
      province: 'Cebu',
      contact_number: '09123456789',
      email: 'juan@example.com'
    };
  
    guestFillForm(user);
    guestSetReadonly(true);
    statusBox.innerHTML = '<div class="alert alert-success">Record found. Please verify your details before signing in or out.</div>';
    formFields.classList.remove('hide');
    actionBox.classList.remove('hide');
    registerBtn.classList.add('hide');
    signInBtn.classList.remove('hide');
    signOutBtn.classList.remove('hide');
  } else {
    guestClearForm();
    guestSetReadonly(false);
    // Pre-fill name fields from what was typed
    const fnEl = document.getElementById('guest_first_name');
    const mnEl = document.getElementById('guest_middle_name');
    const lnEl = document.getElementById('guest_last_name');
    if (fnEl) fnEl.value = fname;
    if (mnEl) mnEl.value = mname;
    if (lnEl) lnEl.value = lname;
    statusBox.innerHTML = '<div class="alert alert-info">No previous record found. Please complete the registration form.</div>';
    formFields.classList.remove('hide');
    actionBox.classList.remove('hide');
    registerBtn.classList.remove('hide');
    signInBtn.classList.add('hide');
    signOutBtn.classList.add('hide');
  }

}

function guestFillForm(user) {
  const fields = ['first_name', 'middle_name', 'last_name','barangay','city','province','contact_number','email'];
  fields.forEach(k => {
    const el = document.getElementById('guest_' + k);
    if (el) el.value = user[k] || '';
  });
}

function guestClearForm() {
  const fields = ['first_name', 'middle_name', 'last_name','barangay','city','province','contact_number','email'];
  fields.forEach(k => {
    const el = document.getElementById('guest_' + k);
    if (el) el.value = '';
  });
}

function guestSetReadonly(readonly) {
  const fields = ['first_name', 'middle_name', 'last_name','barangay','city','province','contact_number','email'];
  fields.forEach(k => {
    const el = document.getElementById('guest_' + k);
    if (el) el.readOnly = readonly;
  });
}

function guestPrepareAction(action) {
  const actionField = document.getElementById('guest_action');
  if (actionField) actionField.value = action;
  return true;
}
