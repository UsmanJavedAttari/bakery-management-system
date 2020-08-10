<template>
  <validation-provider :rules="rules" v-slot="{ errors }">
    <v-checkbox
      :error-messages="errors"
      v-bind="$attrs"
      v-on="$listeners"
      :value="value"
      :input-value="inputValue"
      @change="
                $emit('update:inputValue', $event);
            "
    >
      <template #label v-if="!!$attrs.label">
        <span class="error--text" v-if="rules.includes('true')">*</span>
        {{ $attrs.label }}
      </template>
      <slot v-for="slot in Object.keys($slots)" :name="slot" :slot="slot" />
    </v-checkbox>
  </validation-provider>
</template>

<script lang="ts" src="./base-checkbox.ts" />
