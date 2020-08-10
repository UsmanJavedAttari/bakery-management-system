<template>
  <validation-provider :rules="rules" v-slot="{ errors }">
    <v-switch
      class="ma-0 pa-0"
      :error-messages="errors"
      v-bind="$attrs"
      v-on="$listeners"
      :input-value="inputValue"
      @change="
                $emit('update:inputValue', $event);
            "
      inset
    >
      <template #label v-if="!!$attrs.label">
        <span class="error--text" v-if="rules.includes('true')">*</span>
        {{ $attrs.label }}
      </template>
      <slot v-for="slot in Object.keys($slots)" :name="slot" :slot="slot" />
    </v-switch>
  </validation-provider>
</template>

<script lang="ts" src="./base-switch.ts" />
