<template>
  <validation-provider :rules="rules" v-slot="{ errors }">
    <v-autocomplete
      :error-messages="errors"
      v-bind="$attrs"
      v-on="$listeners"
      :value="value"
      @change="
                $emit('update:value', !!$event ? $event : null);
            "
      :outlined="outlined"
      :dense="outlined"
    >
      <template #label v-if="!!$attrs.label">
        <span class="error--text" v-if="rules.includes('required')">*</span>
        {{ $attrs.label }}
      </template>
      <slot v-for="slot in Object.keys($slots)" :name="slot" :slot="slot" />
    </v-autocomplete>
  </validation-provider>
</template>

<script lang="ts" src="./base-autocomplete.ts" />
