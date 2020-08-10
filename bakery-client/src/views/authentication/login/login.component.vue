<template>
  <v-row justify="center" align="center">
    <v-col cols="12" md="4">
      <base-card class="round-15 big-shadow overflow-hidden">
        <div class="pa-5">
          <h1 class="mb-3 primary--text">Login</h1>
          <base-form #default="{ invalid }" @submit="login">
            <v-row dense>
              <v-col cols="12">
                <base-text-field
                  :value.sync="LoginData.Email"
                  label="Email"
                  rules="required|email"
                  autofocus
                />
              </v-col>
              <v-col cols="12">
                <base-text-field
                  :value.sync="LoginData.Password"
                  label="Password"
                  type="password"
                  rules="required|min:8|max:36"
                />
              </v-col>
              <v-col cols="12">
                <base-btn :disabled="invalid" block type="submit">Login</base-btn>
              </v-col>
            </v-row>
          </base-form>
        </div>
        <p class="text-center">
          New here?
          <router-link to="/signup">Signup</router-link>
        </p>
      </base-card>
    </v-col>
  </v-row>
</template>

<script lang="ts" src="./login.component.ts" />
