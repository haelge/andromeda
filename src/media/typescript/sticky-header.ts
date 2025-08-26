document.addEventListener('DOMContentLoaded', () => {
  ((header: HTMLElement | null) => {
    let sticky = false;
    window.onscroll = (ev: Event) => {
      console.log(header?.getBoundingClientRect().top);

      if (!sticky && <number>header?.getBoundingClientRect().top <= 0) {
        header?.classList.add('position-sticky', 'sticky-top');
        sticky = true;
      } else if (sticky && <number>header?.getBoundingClientRect().top > 0) {
        header?.classList.remove('position-sticky', 'sticky-top');
        sticky = false;
      }
    };
  })(document.querySelector('header.header .container-nav'));
});
