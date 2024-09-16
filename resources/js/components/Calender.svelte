<script>
    import { getDateRows, uuid, noop } from "./date-time.js";
    import { createEventDispatcher } from "svelte";
  
    const dispatch = createEventDispatcher();
  
    // props
    export let date;
    export let month;
    export let year;
    export let isAllowed;
  
    // local vars to help in render
    const weekdays = ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sáb"];
    let cells;
  
    // function helpers
    const onChange = date => {
      console.log({date})
      dispatch("datechange", new Date(year, month, date));
    };
  
    const allow = (year, month, date) => {
      if (!date) return true;
      return isAllowed(new Date(year, month, date));
    };
  
    $: cells = getDateRows(month, year).map(c => ({
      value: c,
      allowed: allow(year, month, c)
    }));
  </script>
  
  <style>
    .container {
      margin-top: 8px;
      padding: 6px;
      margin: auto;
      width: 300px;
    }
    .row {
      display: grid;
      grid-template-columns: repeat(7, 1fr);
      margin: 1px 2px;
      flex-wrap: wrap;
    }
  
    .cell {
      display: inline-block;
      width: 27px;
      height: 27px;
      text-align: center;
      line-height: 20px;
      padding: 4px;
      margin: 1px;
      font-size: 13px;
      border-radius: 100px;
    }
  
    .selected {
      background: #2477BF;
      color: white;
      /* color2 : "#397373",
          color3 : "#6595BF",
          color4 : "#C9EBF2", */
    }
  
    .highlight {
      transition: transform 0.2s cubic-bezier(0.165, 0.84, 0.44, 1);
    }
  
    .disabled {
      background: #efefef;
      cursor: not-allowed;
      color: #bfbfbf;
    }
  
    .highlight:hover {
      background: #397373;
      color: #fff;
      cursor: pointer;
      transform: scale(1.3);
    }
  
    .selected.highlight:hover {
      background: #C9EBF2;
    }
  </style>
  
  <div class="container">
    <div class="row">
      {#each weekdays as day}
        <div class="cell">{day}</div>
      {/each}
    </div>
  
    <div class="row">
      {#each cells as { allowed, value } (uuid())}
        <div
          on:mousedown={allowed && value ? onChange.bind(this, value) : noop}
          class:cell={true}
          class:highlight={allowed && value}
          class:disabled={!allowed}
          class:selected={new Date(date.getFullYear(), date.getMonth(), date.getDate()).getTime() === new Date(year, month, value).getTime()}>
          {value || ''}
        </div>
      {/each}
    </div>
  </div>
  