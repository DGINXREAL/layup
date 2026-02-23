<x-filament-panels::page>
    <div
        wire:ignore
        x-data="layupBuilder({
            content: @js($pageContent),
            breakpoints: @js($this->breakpoints),
            defaultBreakpoint: @js($this->defaultBreakpoint),
            rowTemplates: @js($this->rowTemplates),
            widgetRegistry: @js($this->widgetRegistry),
        })"
        class="lyp-wrap"
        x-on:content-updated.window="pushHistory(); content = Array.isArray($event.detail) ? $event.detail[0] : $event.detail"
    @keydown.window="onKeyDown($event)"
    >
        {{-- Top Bar --}}
        <div class="lyp-toolbar">
            <div class="lyp-bp-group">
                <template x-for="(bp, key) in breakpoints" :key="key">
                    <button
                        @click="currentBreakpoint = key"
                        :class="{'lyp-bp-btn': true, 'active': currentBreakpoint === key}"
                    >
                        <span x-text="bp.label"></span>
                        <span style="font-size:0.7rem;opacity:0.7" x-text="bp.width + 'px'"></span>
                    </button>
                </template>
            </div>

            <div class="lyp-toolbar-right">
                <div class="lyp-undo-group">
                    <button @click="undo()" :disabled="historyIndex <= 0" class="lyp-toolbar-icon" title="Undo (Ctrl+Z)">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3"/></svg>
                    </button>
                    <button @click="redo()" :disabled="historyIndex >= history.length - 1" class="lyp-toolbar-icon" title="Redo (Ctrl+Shift+Z)">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 15l6-6m0 0l-6-6m6 6H9a6 6 0 000 12h3"/></svg>
                    </button>
                </div>
                <span class="lyp-preview-label" x-text="'Preview: ' + breakpoints[currentBreakpoint].width + 'px'"></span>
            </div>
        </div>

        {{-- Canvas --}}
        <div class="lyp-canvas">
            <div class="lyp-canvas-inner" :style="'max-width:' + breakpoints[currentBreakpoint].width + 'px'">
                {{-- Ruler --}}
                <div class="lyp-ruler">
                    <template x-for="i in 12" :key="i">
                        <div class="lyp-ruler-cell" x-text="i"></div>
                    </template>
                </div>

                {{-- Rows --}}
                <div class="lyp-rows">
                    {{-- Insert-between zone before first row --}}
                    <div class="lyp-insert-zone" x-data="{ showTemplates: false }" @mouseenter="$el.classList.add('lyp-insert-zone--hover')" @mouseleave="if(!showTemplates) $el.classList.remove('lyp-insert-zone--hover')">
                        <div class="lyp-insert-line">
                            <button @click.stop="showTemplates = !showTemplates" class="lyp-insert-btn" title="Add row">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                            </button>
                        </div>
                        <div x-show="showTemplates" @click.away="showTemplates = false; $el.closest('.lyp-insert-zone').classList.remove('lyp-insert-zone--hover')" x-transition class="lyp-templates lyp-templates--inline">
                            <p>Choose a layout:</p>
                            <div class="lyp-templates-grid">
                                <template x-for="(template, idx) in rowTemplates" :key="idx">
                                    <button @click="$wire.addRowAt(template, 0); showTemplates = false; $el.closest('.lyp-insert-zone').classList.remove('lyp-insert-zone--hover')" class="lyp-tpl-btn">
                                        <template x-for="(span, ci) in template" :key="ci">
                                            <div class="lyp-tpl-col" :style="'flex:' + span + ' ' + span + ' 0%'"></div>
                                        </template>
                                    </button>
                                </template>
                            </div>
                        </div>
                    </div>

                    <template x-for="(row, rowIndex) in content.rows" :key="row.id">
                        <div>
                        {{-- Row drop indicator --}}
                        <div
                            class="lyp-row-drop-indicator"
                            :class="{ 'lyp-row-drop-indicator--active': rowDrag.dropIndex === rowIndex }"
                        ></div>
                        <div
                            class="lyp-row"
                            :class="{ 'lyp-row--dragging': rowDrag.active && rowDrag.rowId === row.id }"
                            @click.self="$wire.editRow(row.id)"
                            @dragover.prevent.stop="onRowDragOver($event, rowIndex)"
                            @drop.prevent="onRowDrop($event)"
                        >
                            <div class="lyp-row-header">
                                <div style="display:flex;align-items:center;gap:0.375rem">
                                    <span
                                        class="lyp-drag-handle"
                                        draggable="true"
                                        @dragstart.stop="onRowDragStart($event, row.id, rowIndex)"
                                        @dragend="onRowDragEnd()"
                                        title="Drag to reorder"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9h16.5m-16.5 6.75h16.5"/></svg>
                                    </span>
                                    <span class="lyp-row-label" x-text="'Row ' + (rowIndex + 1)"></span>
                                </div>
                                <div class="lyp-row-actions">
                                    <button @click.stop="$wire.addColumn(row.id)" title="Add column">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                                    </button>
                                    <button @click.stop="$wire.duplicateRow(row.id)" title="Duplicate row">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 01-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 011.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 00-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 01-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 00-3.375-3.375h-1.5a1.125 1.125 0 01-1.125-1.125v-1.5a3.375 3.375 0 00-3.375-3.375H9.75"/></svg>
                                    </button>
                                    <button @click.stop="$wire.editRow(row.id)" title="Row settings">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    </button>
                                    <button @click.stop="if(confirm('Delete this row?')) $wire.deleteRow(row.id)" class="danger" title="Delete row">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                                    </button>
                                </div>
                            </div>

                            {{-- Columns --}}
                            <div class="lyp-columns" :style="'gap:' + (row.settings.gap ? row.settings.gap.replace('gap-','').replace('0','0px').replace('2','0.5rem').replace('4','1rem').replace('6','1.5rem').replace('8','2rem').replace('12','3rem') : '1rem')">
                                <template x-for="(col, colIndex) in row.columns" :key="col.id">
                                    <div
                                        class="lyp-col"
                                        :class="{ 'lyp-col--drop-target': drag.active && !(drag.sourceRowId === row.id && drag.sourceColId === col.id && col.widgets.length === 1) }"
                                        :style="'grid-column: span ' + getColSpan(col) + ' / span ' + getColSpan(col)"
                                        @click.self="$wire.editColumn(row.id, col.id)"
                                        @dragover.prevent="onDragOverCol($event, row.id, col.id)"
                                        @dragleave="onDragLeaveCol($event)"
                                        @drop.prevent="onDropCol($event, row.id, col.id)"
                                    >
                                        <div class="lyp-col-header">
                                            <span class="lyp-col-label" x-text="'Col ' + (colIndex + 1) + ' · ' + getColSpan(col) + '/12'"></span>
                                            <div class="lyp-col-actions">
                                                <button @click.stop="$wire.moveColumn(row.id, col.id, 'left')" :disabled="colIndex === 0" class="lyp-col-settings-btn" title="Move left">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
                                                </button>
                                                <button @click.stop="$wire.moveColumn(row.id, col.id, 'right')" :disabled="colIndex === row.columns.length - 1" class="lyp-col-settings-btn" title="Move right">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                                                </button>
                                                <button @click.stop="$wire.editColumn(row.id, col.id)" class="lyp-col-settings-btn" title="Column settings">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                                </button>
                                                <button @click.stop="if(confirm('Delete this column?')) $wire.deleteColumn(row.id, col.id)" class="lyp-col-settings-btn danger" title="Delete column">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                                                </button>
                                            </div>
                                        </div>

                                        {{-- Widgets --}}
                                        <div class="lyp-widgets">
                                            <template x-for="(widget, widgetIndex) in col.widgets" :key="widget.id">
                                                <div>
                                                    {{-- Drop indicator before widget --}}
                                                    <div
                                                        class="lyp-drop-indicator"
                                                        :class="{ 'lyp-drop-indicator--active': drag.dropTarget?.rowId === row.id && drag.dropTarget?.colId === col.id && drag.dropTarget?.position === widgetIndex }"
                                                    ></div>
                                                    <div
                                                        class="lyp-widget"
                                                        :class="{ 'lyp-widget--dragging': drag.active && drag.widgetId === widget.id }"
                                                        draggable="true"
                                                        @dragstart="onDragStart($event, row.id, col.id, widget.id, widgetIndex)"
                                                        @dragend="onDragEnd()"
                                                        @dragover.prevent.stop="onDragOverWidget($event, row.id, col.id, widgetIndex)"
                                                        @click.stop="$wire.editWidget(row.id, col.id, widget.id)"
                                                    >
                                                        <div class="lyp-widget-header">
                                                            <div style="display:flex;align-items:center;gap:0.375rem">
                                                                <span class="lyp-drag-handle" title="Drag to reorder">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9h16.5m-16.5 6.75h16.5"/></svg>
                                                                </span>
                                                                <span class="lyp-widget-type" x-text="getWidgetLabel(widget.type)"></span>
                                                            </div>
                                                            <div class="lyp-widget-actions">
                                                                <button @click.stop="$wire.editWidget(row.id, col.id, widget.id)" title="Edit">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125"/></svg>
                                                                </button>
                                                                <button @click.stop="$wire.duplicateWidget(row.id, col.id, widget.id)" title="Duplicate">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 01-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 011.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 00-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 01-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 00-3.375-3.375h-1.5a1.125 1.125 0 01-1.125-1.125v-1.5a3.375 3.375 0 00-3.375-3.375H9.75"/></svg>
                                                                </button>
                                                                <button @click.stop="if(confirm('Delete this widget?')) $wire.deleteWidget(row.id, col.id, widget.id)" class="danger" title="Delete">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="lyp-widget-preview" x-text="getWidgetPreview(widget)"></div>
                                                    </div>
                                                </div>
                                            </template>

                                            {{-- Drop indicator after last widget --}}
                                            <div
                                                class="lyp-drop-indicator"
                                                :class="{ 'lyp-drop-indicator--active': drag.dropTarget?.rowId === row.id && drag.dropTarget?.colId === col.id && drag.dropTarget?.position === col.widgets.length }"
                                            ></div>
                                        </div>

                                        {{-- Add Widget --}}
                                        <div style="position:relative" x-data="{ showWidgets: false }">
                                            <button @click.stop="showWidgets = !showWidgets" class="lyp-add-widget">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                                                Add Widget
                                            </button>
                                            <div x-show="showWidgets" @click.away="showWidgets = false" x-transition class="lyp-widget-picker">
                                                <template x-for="cat in getWidgetCategories()" :key="cat.name">
                                                    <div>
                                                        <div class="lyp-widget-picker-cat" x-text="cat.name"></div>
                                                        <template x-for="w in cat.widgets" :key="w.type">
                                                            <button @click.stop="$wire.addWidget(row.id, col.id, w.type); showWidgets = false" class="lyp-widget-picker-item">
                                                                <span x-text="w.label"></span>
                                                            </button>
                                                        </template>
                                                    </div>
                                                </template>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>

                        {{-- Insert-between zone after this row --}}
                        <div class="lyp-insert-zone" x-data="{ showTemplates: false }" @mouseenter="$el.classList.add('lyp-insert-zone--hover')" @mouseleave="if(!showTemplates) $el.classList.remove('lyp-insert-zone--hover')">
                            <div class="lyp-insert-line">
                                <button @click.stop="showTemplates = !showTemplates" class="lyp-insert-btn" title="Add row">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                                </button>
                            </div>
                            <div x-show="showTemplates" @click.away="showTemplates = false; $el.closest('.lyp-insert-zone').classList.remove('lyp-insert-zone--hover')" x-transition class="lyp-templates lyp-templates--inline">
                                <p>Choose a layout:</p>
                                <div class="lyp-templates-grid">
                                    <template x-for="(template, idx) in rowTemplates" :key="idx">
                                        <button @click="$wire.addRowAt(template, rowIndex + 1); showTemplates = false; $el.closest('.lyp-insert-zone').classList.remove('lyp-insert-zone--hover')" class="lyp-tpl-btn">
                                            <template x-for="(span, ci) in template" :key="ci">
                                                <div class="lyp-tpl-col" :style="'flex:' + span + ' ' + span + ' 0%'"></div>
                                            </template>
                                        </button>
                                    </template>
                                </div>
                            </div>
                        </div>
                        </div>
                    </template>

                    {{-- Drop indicator after last row --}}
                    <div
                        class="lyp-row-drop-indicator"
                        :class="{ 'lyp-row-drop-indicator--active': rowDrag.dropIndex === content.rows.length }"
                        @dragover.prevent="if(rowDrag.active) rowDrag.dropIndex = content.rows.length"
                        @drop.prevent="onRowDrop($event)"
                        style="min-height: 0.5rem"
                    ></div>

                    {{-- Persistent Add Row button below all rows --}}
                    <div class="lyp-add-row-bottom" x-data="{ showTemplates: false }">
                        <button @click.stop="showTemplates = !showTemplates" class="lyp-add-row-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                            Add Row
                        </button>
                        <div x-show="showTemplates" @click.away="showTemplates = false" x-transition class="lyp-templates lyp-templates--bottom">
                            <p>Choose a layout:</p>
                            <div class="lyp-templates-grid">
                                <template x-for="(template, idx) in rowTemplates" :key="idx">
                                    <button @click="$wire.addRow(template); showTemplates = false" class="lyp-tpl-btn">
                                        <template x-for="(span, ci) in template" :key="ci">
                                            <div class="lyp-tpl-col" :style="'flex:' + span + ' ' + span + ' 0%'"></div>
                                        </template>
                                    </button>
                                </template>
                            </div>
                        </div>
                    </div>

                    {{-- Empty State --}}
                    <template x-if="!content.rows || content.rows.length === 0">
                        <div class="lyp-empty">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z"/></svg>
                            <p>No rows yet. Click <strong>+ Add Row</strong> to get started.</p>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>

    @script
    <script>
        Alpine.data('layupBuilder', (config) => ({
            content: config.content,
            breakpoints: config.breakpoints,
            currentBreakpoint: config.defaultBreakpoint,
            rowTemplates: config.rowTemplates,
            widgetRegistry: config.widgetRegistry,

            // Undo/Redo
            history: [],
            historyIndex: -1,
            maxHistory: 50,

            init() {
                // Seed initial state
                this.history = [JSON.parse(JSON.stringify(this.content))];
                this.historyIndex = 0;
            },

            pushHistory() {
                // Snapshot current state before incoming update
                const snapshot = JSON.parse(JSON.stringify(this.content));
                // Trim any forward history
                this.history = this.history.slice(0, this.historyIndex + 1);
                this.history.push(snapshot);
                if (this.history.length > this.maxHistory) {
                    this.history.shift();
                } else {
                    this.historyIndex++;
                }
            },

            undo() {
                if (this.historyIndex <= 0) return;
                // Save current state as forward history if we're at the tip
                if (this.historyIndex === this.history.length - 1) {
                    this.history.push(JSON.parse(JSON.stringify(this.content)));
                }
                this.historyIndex--;
                const state = JSON.parse(JSON.stringify(this.history[this.historyIndex]));
                this.content = state;
                $wire.restoreContent(state);
            },

            redo() {
                if (this.historyIndex >= this.history.length - 1) return;
                this.historyIndex++;
                const state = JSON.parse(JSON.stringify(this.history[this.historyIndex]));
                this.content = state;
                $wire.restoreContent(state);
            },

            onKeyDown(e) {
                // Ctrl/Cmd+Z = undo, Ctrl/Cmd+Shift+Z = redo
                if ((e.ctrlKey || e.metaKey) && e.key === 'z' && !e.shiftKey) {
                    e.preventDefault();
                    this.undo();
                }
                if ((e.ctrlKey || e.metaKey) && e.key === 'z' && e.shiftKey) {
                    e.preventDefault();
                    this.redo();
                }
                // Ctrl/Cmd+Y = redo (alternative)
                if ((e.ctrlKey || e.metaKey) && e.key === 'y') {
                    e.preventDefault();
                    this.redo();
                }
            },

            // Row drag state
            rowDrag: {
                active: false,
                rowId: null,
                sourceIndex: null,
                dropIndex: null,
            },

            onRowDragStart(e, rowId, index) {
                this.rowDrag = { active: true, rowId, sourceIndex: index, dropIndex: null };
                e.dataTransfer.effectAllowed = 'move';
                e.dataTransfer.setData('text/plain', 'row:' + rowId);
            },

            onRowDragEnd() {
                this.rowDrag = { active: false, rowId: null, sourceIndex: null, dropIndex: null };
            },

            onRowDragOver(e, rowIndex) {
                if (!this.rowDrag.active) return;
                const rect = e.currentTarget.getBoundingClientRect();
                const midY = rect.top + rect.height / 2;
                const position = e.clientY < midY ? rowIndex : rowIndex + 1;
                if (position === this.rowDrag.sourceIndex || position === this.rowDrag.sourceIndex + 1) {
                    this.rowDrag.dropIndex = null;
                    return;
                }
                this.rowDrag.dropIndex = position;
            },

            onRowDrop(e) {
                if (!this.rowDrag.active || this.rowDrag.dropIndex === null) return;
                const { rowId, sourceIndex, dropIndex } = this.rowDrag;
                let targetIndex = dropIndex;
                if (sourceIndex < targetIndex) targetIndex--;
                this.onRowDragEnd();
                if (sourceIndex !== targetIndex) {
                    $wire.moveRowTo(rowId, targetIndex);
                }
            },

            // Widget drag state
            drag: {
                active: false,
                widgetId: null,
                sourceRowId: null,
                sourceColId: null,
                sourceIndex: null,
                dropTarget: null, // { rowId, colId, position }
            },

            onDragStart(e, rowId, colId, widgetId, index) {
                this.drag = {
                    active: true,
                    widgetId,
                    sourceRowId: rowId,
                    sourceColId: colId,
                    sourceIndex: index,
                    dropTarget: null,
                };
                e.dataTransfer.effectAllowed = 'move';
                e.dataTransfer.setData('text/plain', widgetId);
            },

            onDragEnd() {
                this.drag = { active: false, widgetId: null, sourceRowId: null, sourceColId: null, sourceIndex: null, dropTarget: null };
            },

            onDragOverWidget(e, rowId, colId, widgetIndex) {
                if (!this.drag.active) return;
                const rect = e.currentTarget.getBoundingClientRect();
                const midY = rect.top + rect.height / 2;
                const position = e.clientY < midY ? widgetIndex : widgetIndex + 1;

                // Skip if dropping in same spot
                if (rowId === this.drag.sourceRowId && colId === this.drag.sourceColId) {
                    if (position === this.drag.sourceIndex || position === this.drag.sourceIndex + 1) {
                        this.drag.dropTarget = null;
                        return;
                    }
                }

                this.drag.dropTarget = { rowId, colId, position };
            },

            onDragOverCol(e, rowId, colId) {
                if (!this.drag.active) return;
                // Only set drop target on empty column area (widgets handle their own)
                const col = this.findCol(rowId, colId);
                if (col && col.widgets.length === 0) {
                    this.drag.dropTarget = { rowId, colId, position: 0 };
                }
            },

            onDragLeaveCol(e) {
                // Clear if leaving the column entirely
                if (!e.currentTarget.contains(e.relatedTarget)) {
                    this.drag.dropTarget = null;
                }
            },

            onDropCol(e, rowId, colId) {
                if (!this.drag.active || !this.drag.dropTarget) return;
                const dt = this.drag.dropTarget;
                const { sourceRowId, sourceColId, widgetId, sourceIndex } = this.drag;

                // Adjust position if moving within same column and source is before target
                let position = dt.position;
                if (sourceRowId === dt.rowId && sourceColId === dt.colId && sourceIndex < position) {
                    position--;
                }

                this.onDragEnd();
                $wire.moveWidgetTo(sourceRowId, sourceColId, widgetId, dt.rowId, dt.colId, position);
            },

            findCol(rowId, colId) {
                const row = this.content.rows.find(r => r.id === rowId);
                return row ? row.columns.find(c => c.id === colId) : null;
            },

            getColSpan(col) {
                const bp = this.currentBreakpoint;
                return col.span?.[bp] ?? col.span?.lg ?? 6;
            },

            getWidgetLabel(type) {
                const w = this.widgetRegistry.find(r => r.type === type);
                return w ? w.label : type;
            },

            getWidgetCategories() {
                const cats = {};
                const order = ['content', 'media', 'interactive', 'layout', 'advanced'];
                this.widgetRegistry.forEach(w => {
                    const cat = w.category || 'content';
                    if (!cats[cat]) cats[cat] = { name: cat, widgets: [] };
                    cats[cat].widgets.push(w);
                });
                return order.filter(c => cats[c]).map(c => cats[c])
                    .concat(Object.keys(cats).filter(c => !order.includes(c)).map(c => cats[c]));
            },

            getWidgetPreview(widget) {
                const data = widget.data || {};
                if (data.content) {
                    const tmp = document.createElement('div');
                    tmp.innerHTML = data.content;
                    const text = tmp.textContent || tmp.innerText || '';
                    return text.substring(0, 60) + (text.length > 60 ? '...' : '');
                }
                if (data.label) return data.label;
                if (data.src) return 'Image: ' + data.src;
                return '(empty)';
            },
        }));
    </script>
    @endscript
</x-filament-panels::page>
