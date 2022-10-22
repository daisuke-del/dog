export default {
  transitionMaintenanceNoticePage(link, newTab) {
    if (newTab) {
      window.open(link, '_blank')
      return
    }
    if (link.indexOf('https://') === 0) {
      window.location.replace(link)
      return
    }
    window.$nuxt.$router.replace(link)
  }
}