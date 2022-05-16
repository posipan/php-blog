import '../sass/style.scss';
import { showMessage } from './msg';
import { initPreview, createPreview } from './img';
import { menu } from './menu';

menu();
showMessage('.toast');

if (document.getElementById('form--post') !== null) {
  initPreview();

  const uploadImage = document.getElementById('upload-image') as HTMLInputElement;
  uploadImage.addEventListener('change', function () {
    createPreview(this);
  });
}
