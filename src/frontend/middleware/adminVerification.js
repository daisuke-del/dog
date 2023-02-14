import admin from "@/plugins/modules/admin"
export default function ({ app }) {
    if (app.store.getters['adminInfo/login'] === 1) {
        return
    } else {
        admin.logout().then(() =>{
            app.router.push('/login')
        }).catch(() => {
            app.router.push('/')
        })
    }
  }
