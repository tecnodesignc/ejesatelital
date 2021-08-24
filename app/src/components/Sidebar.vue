<template>
  <q-list padding id="sidebar-menu">
    <q-item clickable v-ripple to="/" active-class="active" exact>
      <q-item-section avatar>
        <q-icon name="inbox"/>
      </q-item-section>
      <q-item-section>
        Dashboard
      </q-item-section>
    </q-item>
    <q-expansion-item
      expand-separator
      icon="business"
      label="Compañias"
      v-if="helper.hasAccess('company.accounts.index')||helper.hasAccess('company.accounttypes.index')||helper.hasAccess('company.contacts.index')"
    >
      <q-item clickable v-ripple :to="{name:'company.account.index'}" v-if="helper.hasAccess('company.accounts.index')" active-class="active" exact class="q-pl-lg">
        <q-item-section avatar>
          <q-icon name="arrow_right"/>
        </q-item-section>
        <q-item-section>
          Empresas
        </q-item-section>
      </q-item>
      <q-item clickable v-ripple :to="{name:'company.account-type.index'}" v-if="helper.hasAccess('company.accounttypes.index')" active-class="active" exact class="q-pl-lg">
        <q-item-section avatar>
          <q-icon name="arrow_right"/>
        </q-item-section>
        <q-item-section>
          Tipos de Empresas
        </q-item-section>
      </q-item>
      <q-item clickable v-ripple :to="{name:'company.contact.index'}" v-if="helper.hasAccess('company.contacts.index')" active-class="active" exact class="q-pl-lg">
        <q-item-section avatar>
          <q-icon name="arrow_right"/>
        </q-item-section>
        <q-item-section>
          Contactos
        </q-item-section>
      </q-item>
    </q-expansion-item>
    <q-expansion-item
      expand-separator
      icon="commute"
      label="Vehiculos"
      v-if="helper.hasAccess('vehicle.vehicles.index') || helper.hasAccess('vehicle.brands.index')"
    >
      <q-item clickable v-ripple :to="{name:'vehicle.vehicle.index'}" v-if="helper.hasAccess('vehicle.vehicles.index')" active-class="active" exact class="q-pl-lg">
        <q-item-section avatar>
          <q-icon name="arrow_right"/>
        </q-item-section>
        <q-item-section>
          Vehiculos
        </q-item-section>
      </q-item>
      <q-item clickable v-ripple :to="{name:'vehicle.brand.index'}" active-class="active" v-if="helper.hasAccess('vehicle.brands.index')" exact class="q-pl-lg">
        <q-item-section avatar>
          <q-icon name="arrow_right"/>
        </q-item-section>
        <q-item-section>
          Marcas
        </q-item-section>
      </q-item>
    </q-expansion-item>
    <q-item clickable v-ripple :to="{name:'polls.index'}" active-class="active" v-if="helper.hasAccess('polls.polls.index')"  exact>
      <q-item-section avatar>
        <q-icon name="poll"/>
      </q-item-section>
      <q-item-section>
        Formularios
      </q-item-section>
    </q-item>
    <q-item clickable v-ripple :to="{name:'polls.fill'}" active-class="active" exact>
      <q-item-section avatar>
        <q-icon name="poll"/>
      </q-item-section>
      <q-item-section>
        Formularios Disponibles
      </q-item-section>
    </q-item>
    <q-expansion-item
      expand-separator
      icon="people_outline"
      label="Usuarios"
      v-if="helper.hasAccess('user.users.index')||helper.hasAccess('user.roles.index')"
    >
      <q-item clickable v-ripple :to="{name:'user.index'}" active-class="active" v-if="helper.hasAccess('user.users.index')" exact class="q-pl-lg">
        <q-item-section avatar>
          <q-icon name="arrow_right"/>
        </q-item-section>
        <q-item-section>
          Usuarios
        </q-item-section>
      </q-item>
      <q-item clickable v-ripple :to="{name:'role.index'}"  v-if="helper.hasAccess('user.roles.index')" active-class="active" exact class="q-pl-lg">
        <q-item-section avatar>
          <q-icon name="arrow_right"/>
        </q-item-section>
        <q-item-section>
          Roles
        </q-item-section>
      </q-item>
    </q-expansion-item>

  </q-list>
</template>

<script>
//import { ref } from 'vue'
import helper from "src/plugins/helpers";
export default {
  name: 'Sidebar',
  props: {},
  setup(){
    return{
      helper
    }
  }
}
</script>

<style lang="scss">


.active {
  color: $primary !important;
  background-color: #f5f7fa !important;
}

#sidebar-menu {
  .q-item {
    color: $secondary;
    font-size: 14.5px;
    transition: all .4s;
    border-radius: 3px;

    i {
      font-size: 16px;
      color: $secondary;
      transition: all .4s;
    }

  }

  .badge {
    margin-top: 5px;
  }

  ul.sub-menu {
    padding: 0;

    li {

      a {
        padding: .4rem 1.5rem .4rem 2.8rem;
        font-size: 14px;
        color: $secondary;
        background-color: transparent !important;
      }

      ul.sub-menu {
        padding: 0;

        li {
          a {
            padding: .4rem 1.5rem .4rem 4rem;
            font-size: 14px;
          }
        }
      }
    }
  }
}


.menu-title {
  padding: 12px 20px !important;
  letter-spacing: .05em;
  pointer-events: none;
  cursor: default;
  font-size: 11px;
  text-transform: uppercase;
  color: $secondary;
  font-weight: 600;
}

</style>
