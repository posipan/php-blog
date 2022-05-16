export const showMessage = (elem: string): void => {
  const time: number = 4000;
  const $toastElm = document.querySelector(elem);

  if ($toastElm !== null) {
    $toastElm.classList.add('active');
    setTimeout(() => {
      $toastElm.classList.remove('active');
    }, time);
  }
};
