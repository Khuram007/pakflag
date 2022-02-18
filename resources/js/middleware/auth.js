
export default function auth({ next, router }) {
  if (!localStorage.getItem('pf_user_token')) {
    return router.push({ name: 'login' });
  }
  return next();
}
