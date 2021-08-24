<template>
  <div class="">
    <q-btn-dropdown dense content-style="box-shadow: 0 1rem 3rem rgb(0 0 0 / 18%); border:none" flat icon="far fa-bell"
                    class="notification-bell" no-caps color="secondary" @hide="readNotification">
      <template v-slot:label v-if="count">
        <q-badge color="red" floating>{{ count }}</q-badge>
      </template>
      <q-list padding class="rounded-borders list-notification" style=" max-width: 350px">
        <q-toolbar class="row">
          <q-toolbar-title>Notificaciones</q-toolbar-title>
          <q-btn flat color="primary" class="view-more" label="Ver mas"/>
        </q-toolbar>
        <q-scroll-area style="height: 218px; width: 320px;">
          <q-item v-ripple v-for="(item, i) in notifications" :key="item.id" :active="!item.is_read"
                  active-class="bg-indigo-1">
            <q-item-section avatar top>
              <q-avatar size="md" :icon="item.entity" color="primary" text-color="white"/>
            </q-item-section>
            <q-item-section>
              <q-item-label overline lines="1">{{ item.title }}</q-item-label>
              <q-item-label class="text-grey-6">
                {{ item.message }}
              </q-item-label>
              <q-item-label caption><i class="far fa-clock"></i> {{item.time_ago}}</q-item-label>
            </q-item-section>
            <!--            <q-item-section top side>
                          <div class="text-grey-8 q-gutter-xs">
                            <q-btn class="gt-xs" size="12px" flat dense round icon="done" />
                          </div>
                        </q-item-section>-->
          </q-item>
        </q-scroll-area>
        <q-separator spaced/>
        <q-btn flat icon="fas fa-arrow-circle-right" color="primary" class="full-width" label="Ver mas"/>
      </q-list>
    </q-btn-dropdown>
  </div>
</template>

<script>
import {ref, onMounted} from 'vue';
import {useRouter, useRoute} from 'vue-router'
import {useQuasar} from "quasar";
import {echo} from "boot/laravel-echo";
import {useStore} from "vuex";
import {api} from "boot/axios";

export default {
  name: 'NotificationDropdown',
  setup() {
    const $q = useQuasar();
    const store = useStore();
    const notifications = ref([])
    const noReadNotification = ref([])
    const count = ref(0)

    const getNotifications = async () => {
      return new Promise(async (resolve, reject) => {

        let params = {
          filter: {
            me: true,
            order:{
              field:'created_at',
              way:'desc'
            }
          },
          include: '',
          take: 10
        }
        api.get('notification/v1/notifications', {params: params}).then(response => {
          notifications.value = response.data.data
          let sum = 0
          notifications.value.forEach(function (item) {
            if (!item.is_read) {
              noReadNotification.value.push(item.id)
              sum++
            }
          })
          count.value = sum
          resolve(true)
        }).catch(error => {
          $q.notify({
            color: 'negative',
            position: 'bottom-right',
            message: 'Error en la consulta de  Cuentas',
            icon: 'report_problem'
          })
          reject(error)
        })
      })
    }

    const readNotification = async () => {
      return new Promise(async (resolve, reject) => {

        count.value = 0
        let params = {
          attributes: {
            ids: noReadNotification.value
          }
        }
        api.post('notification/v1/notifications/readAll', params).then(response => {
          $q.loading.hide()
          getNotifications()
          resolve(true)
        }).catch(error => {
          $q.notify({
            color: 'negative',
            position: 'bottom-right',
            message: 'Error al Actualizar La Encuesta: ' + error.errors,
            icon: 'report_problem'
          })
          $q.loading.hide()
          reject(error)
        });
      })
    }

    const init = async () => {
      echo.channel('notifications').listen('.notifications', message => {
        getNotifications()
      }).listen(`.notifications.user.${store.state.auth.userId}`, message => {
        getNotifications()
      }).listen(`.notifications.account.1`, message => {
        getNotifications()
      })
      await getNotifications()
    }
    onMounted(async () => {
      await init()
    });
    return {
      notifications,
      count,
      readNotification
    };
  }
}
</script>
<style lang="scss">
.notification-bell {
  .q-btn-dropdown__arrow {
    display: none;
  }
}

.list-notification {
  .q-toolbar__title {
    font-weight: 500;
    line-height: 1.2;
    font-size: .875rem;
  }

  .view-more {
    font-size: 80%;
  }
}
</style>
