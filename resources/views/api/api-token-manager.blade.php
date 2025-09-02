<div>
    <!-- إنشاء رمز API -->
    <x-form-section submit="createApiToken">
        <x-slot name="title">
            {{ __('إنشاء رمز API') }}
        </x-slot>

        <x-slot name="description">
            {{ __('تسمح رموز API للخدمات الخارجية بالمصادقة مع تطبيقنا نيابةً عنك.') }}
        </x-slot>

        <x-slot name="form">
            <!-- اسم الرمز -->
            <div class="col-span-6 sm:col-span-4">
                <x-label for="name" value="{{ __('اسم الرمز') }}" />
                <x-input id="name" type="text" class="mt-1 block w-full" wire:model="createApiTokenForm.name" autofocus />
                <x-input-error for="name" class="mt-2" />
            </div>

            <!-- صلاحيات الرمز -->
            @if (Laravel\Jetstream\Jetstream::hasPermissions())
                <div class="col-span-6">
                    <x-label for="permissions" value="{{ __('الصلاحيات') }}" />

                    <div class="mt-2 grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach (Laravel\Jetstream\Jetstream::$permissions as $permission)
                            <label class="flex items-center">
                                <x-checkbox wire:model="createApiTokenForm.permissions" :value="$permission"/>
                                <span class="ms-2 text-sm text-gray-600">{{ $permission }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            @endif
        </x-slot>

        <x-slot name="actions">
            <x-action-message class="me-3" on="created">
                {{ __('تم الإنشاء.') }}
            </x-action-message>

            <x-button>
                {{ __('إنشاء') }}
            </x-button>
        </x-slot>
    </x-form-section>

    @if ($this->user->tokens->isNotEmpty())
        <x-section-border />

        <!-- إدارة رموز API -->
        <div class="mt-10 sm:mt-0">
            <x-action-section>
                <x-slot name="title">
                    {{ __('إدارة رموز API') }}
                </x-slot>

                <x-slot name="description">
                    {{ __('يمكنك حذف أي من الرموز الموجودة إذا لم تعد بحاجة إليها.') }}
                </x-slot>

                <!-- قائمة رموز API -->
                <x-slot name="content">
                    <div class="space-y-6">
                        @foreach ($this->user->tokens->sortBy('name') as $token)
                            <div class="flex items-center justify-between">
                                <div class="break-all">
                                    {{ $token->name }}
                                </div>

                                <div class="flex items-center ms-2">
                                    @if ($token->last_used_at)
                                        <div class="text-sm text-gray-400">
                                            {{ __('آخر استخدام') }} {{ $token->last_used_at->diffForHumans() }}
                                        </div>
                                    @endif

                                    @if (Laravel\Jetstream\Jetstream::hasPermissions())
                                        <button class="cursor-pointer ms-6 text-sm text-gray-400 underline" wire:click="manageApiTokenPermissions({{ $token->id }})">
                                            {{ __('الصلاحيات') }}
                                        </button>
                                    @endif

                                    <button class="cursor-pointer ms-6 text-sm text-red-500" wire:click="confirmApiTokenDeletion({{ $token->id }})">
                                        {{ __('حذف') }}
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </x-slot>
            </x-action-section>
        </div>
    @endif

    <!-- نافذة عرض قيمة الرمز -->
    <x-dialog-modal wire:model.live="displayingToken">
        <x-slot name="title">
            {{ __('رمز API') }}
        </x-slot>

        <x-slot name="content">
            <div>
                {{ __('يرجى نسخ رمز API الجديد الخاص بك. لأمانك، لن يتم عرضه مرة أخرى.') }}
            </div>

            <x-input x-ref="plaintextToken" type="text" readonly :value="$plainTextToken"
                class="mt-4 bg-gray-100 px-4 py-2 rounded font-mono text-sm text-gray-500 w-full break-all"
                autofocus autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false"
                @showing-token-modal.window="setTimeout(() => $refs.plaintextToken.select(), 250)"
            />
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('displayingToken', false)" wire:loading.attr="disabled">
                {{ __('إغلاق') }}
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>

    <!-- نافذة صلاحيات رمز API -->
    <x-dialog-modal wire:model.live="managingApiTokenPermissions">
        <x-slot name="title">
            {{ __('صلاحيات رمز API') }}
        </x-slot>

        <x-slot name="content">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach (Laravel\Jetstream\Jetstream::$permissions as $permission)
                    <label class="flex items-center">
                        <x-checkbox wire:model="updateApiTokenForm.permissions" :value="$permission"/>
                        <span class="ms-2 text-sm text-gray-600">{{ $permission }}</span>
                    </label>
                @endforeach
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('managingApiTokenPermissions', false)" wire:loading.attr="disabled">
                {{ __('إلغاء') }}
            </x-secondary-button>

            <x-button class="ms-3" wire:click="updateApiToken" wire:loading.attr="disabled">
                {{ __('حفظ') }}
            </x-button>
        </x-slot>
    </x-dialog-modal>

    <!-- نافذة تأكيد حذف الرمز -->
    <x-confirmation-modal wire:model.live="confirmingApiTokenDeletion">
        <x-slot name="title">
            {{ __('حذف رمز API') }}
        </x-slot>

        <x-slot name="content">
            {{ __('هل أنت متأكد أنك تريد حذف رمز API هذا؟') }}
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('confirmingApiTokenDeletion')" wire:loading.attr="disabled">
                {{ __('إلغاء') }}
            </x-secondary-button>

            <x-danger-button class="ms-3" wire:click="deleteApiToken" wire:loading.attr="disabled">
                {{ __('حذف') }}
            </x-danger-button>
        </x-slot>
    </x-confirmation-modal>
</div>
