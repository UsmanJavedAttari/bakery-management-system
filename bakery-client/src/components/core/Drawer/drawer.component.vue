<template>
  <v-navigation-drawer
    v-model="CoreService.DrawerMode"
    app
    mobile-breakpoint="991"
    :width="300"
    dark
    class="app-bg-gradient big-shadow"
  >
    <div class="drawer-top py-5 text-center">
      <v-avatar size="70">
        <v-img src="/assets/images/user.png" />
      </v-avatar>
      <div />
      <v-badge color="success" dot offset-y="8" offset-x="-3">
        <h2 class="white--text">{{ ApiAuth.SessionValue.DisplayName }}</h2>
      </v-badge>
      <h5 class="blue-grey--text text--lighten-4 mt-n1">{{ ApiAuth.SessionValue.Email }}</h5>
    </div>
    <v-list dense nav>
      <v-list-item v-for="(Link, i) in DrawerLinks" :key="i" :to="{name: Link.Title}" exact>
        <v-list-item-icon class="mr-3">
          <v-icon>{{ Link.Icon }}</v-icon>
        </v-list-item-icon>
        <v-list-item-content>
          <v-list-item-title>{{ Link.Title }}</v-list-item-title>
        </v-list-item-content>
        <v-list-item-action class="ma-0 pa-0">
          <v-icon size="20" class="ml-1">mdi-chevron-right</v-icon>
        </v-list-item-action>
      </v-list-item>
    </v-list>
    <template #append>
      <div class="pa-3">
        <base-btn
          block
          color="white primary--text"
          @click="ApiAuth.clear(); $router.push({name: 'Home'})"
        >
          Logout
          <v-icon class="ml-1" size="18">mdi-logout</v-icon>
        </base-btn>
      </div>
    </template>
  </v-navigation-drawer>
</template>

<script lang="ts" src="./drawer.component.ts" />
