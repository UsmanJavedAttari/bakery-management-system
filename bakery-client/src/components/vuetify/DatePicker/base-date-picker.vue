<template>
  <v-dialog ref="dialog" v-model="dialog" persistent max-width="320px">
    <template #activator="{ on, attrs }">
      <validation-provider
        :rules="rules.length ? `${rules}|date|valid_date` : 'date|valid_date'"
        v-slot="{ errors }"
        :vid="vid"
      >
        <v-text-field
          :error-messages="errors"
          :value="value"
          @input="$emit('input', $event)"
          :placeholder="fieldProps.label"
          v-bind="attrs"
          outlined
          dense
        >
          <slot v-for="slot in Object.keys($slots)" :name="slot" :slot="slot" />
          <template #append>
            <v-icon v-on="on">mdi-calendar</v-icon>
          </template>
        </v-text-field>
      </validation-provider>
    </template>
    <v-card class="date-picker-card round-10">
      <v-card-text class="pa-0 date-picker-card-text">
        <v-date-picker
          full-width
          color="primary"
          :value="$helpers.isValidDate(value) ? value : null"
          :min="fieldProps.min"
          :max="fieldProps.max"
          v-on:input="$emit('input', $event)"
        />
      </v-card-text>

      <v-card-actions>
        <v-spacer />
        <base-btn text color="primary" @click="$refs.dialog.save(value)">OK</base-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script lang="ts" src="./base-date-picker.ts" />
<style lang="scss" scoped>
.date-picker-card-text {
  max-height: calc(100vh - 100px);
  overflow-x: hidden;
}
</style>
