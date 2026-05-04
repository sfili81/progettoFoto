//SELECT IMAGE FROM MODAL
const selectImage = document.querySelectorAll('.imageselect-item');
const inputIdImg = document.querySelector('#idImagePreview');
const modalImage = document.querySelector('#imageSelect');
let fileInput;

setTimeout(() => {
  fileInput = document.querySelector('.file-caption-name');
}, 1000);

selectImage.forEach((item) => {
  item.addEventListener('click', function () {
    let img_id = item.dataset.key;
    let img_name = item.dataset.name;
    inputIdImg.value = img_id;
    fileInput.value = img_name;
    //modal instance
    let modalInstance = bootstrap.Modal.getInstance(modalImage);
    modalInstance.hide();
  });
});
//END SELECT IMAGE FROM MODAL

//CHECKBOX COLUMN GRIDVIEW
// JS generico per gestire selezione e eliminazione in qualsiasi GridView con CheckboxColumn + PJAX

document.addEventListener('DOMContentLoaded', function () {
  const deleteButton = document.getElementById('delete-selected');
  const gridView = document.querySelector('.grid-view');

  if (!deleteButton || !gridView) return;

  deleteButton.addEventListener('click', function (e) {
    e.preventDefault();

    const gridId = gridView.id;
    const selected = $(`#${gridId}`).yiiGridView('getSelectedRows');

    if (selected.length === 0) {
      alert('Seleziona almeno un elemento.');
      return;
    }

    if (!confirm('Sei sicuro di voler eliminare questi elementi?')) return;

    $.ajax({
      type: 'POST',
      url: deleteButton.dataset.url,
      data: { ids: selected },
      success: function (res) {
        console.log('Risposta server:', res);
        if (res.success) {
          // Ricarica la pagina per mostrare il flash message
          window.location.reload();
        } else {
          alert(res.message || 'Errore generico');
        }
      },
      error: function () {
        alert('Errore di comunicazione con il server.');
      },
    });
  });
});

/************************************************ */
// REORDER FROM KARTIK
$('#uploadfiles-imagefiles').on('filesorted', function (event, params) {
  let form = $('#w0');

  $.ajax({
    url: form.attr('action'),
    type: 'POST',
    data: {
      oldIndex: params.oldIndex,
      newIndex: params.newIndex,
      _csrf: yii.getCsrfToken(),
    },
    success: function (data) {
      console.log('Ordine aggiornato', data);
    },
    error: function () {
      console.log('Errore aggiornamento ordine');
    },
  });
});

/************************************************ */

//TOGGLE MENU SIDEBAR
const expandMenu = document.querySelectorAll('.expandable > span');
expandMenu.forEach((item) => {
  item.addEventListener('click', function () {
    let subMenu = this.nextElementSibling;
    subMenu.classList.contains('expand')
      ? subMenu.classList.remove('expand')
      : subMenu.classList.add('expand');
  });
});
//END TOGGLE MENU SIDEBAR

/* TEST CHART.JS */
const ctx = document.querySelector('#myChart');
if (ctx) {
  fetch('http://yiicms.com/admin/image/chart-img', {
    method: 'GET',
    headers: {
      'X-Requested-With': 'XMLHttpRequest',
    },
  })
    .then(function (response) {
      if (response.ok) {
        return response.json();
      } else {
        return Promise.reject(response);
      }
    })
    .then(function (data) {
      console.log(data);

      let labels = Object.keys(data);
      let values = Object.values(data);
      console.log(values);
      new Chart(ctx, {
        type: 'bar',
        data: {
          labels: labels,
          datasets: [
            {
              label: '# Immagini caricate',
              data: values,
              backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
              ],
              borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
              ],
              borderWidth: 1,
            },
          ],
        },
        options: {
          scales: {
            y: {
              min: 0,
            },
          },
        },
      });
    })
    .catch(function (error) {
      console.warn('Something went wrong.', error);
    });
}

/* APERTURA MENU HEADER */
let openMenuHeader = document.querySelectorAll('.ioDropdown');
openMenuHeader.forEach((el) => {
  el.addEventListener('click', () => {
    console.log('Hai cliccato:', el);
    el.classList.toggle('show');
    // cerca un figlio con la classe ".class"
    let menu = el.parentElement.querySelector('.dropdown-menu');
    if (menu) {
      menu.classList.toggle('show');
    }
    // qui puoi mettere la tua logica, ad esempio:
    // el.classList.toggle('active');
  });
});
