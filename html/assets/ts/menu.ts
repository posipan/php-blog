import { breakPoint } from "./var";

export const menu = () => {
  const $mypageName = document.getElementById('mypage__name');

  if ($mypageName !== null) {
    $mypageName.addEventListener('click', function (e) {
      e.preventDefault();
      const nextElem = this.nextElementSibling as HTMLElement;
      if (window.innerWidth <= breakPoint) {
        nextElem.classList.toggle('active');
      } else {
        return false;
      }
    });
  }
};
