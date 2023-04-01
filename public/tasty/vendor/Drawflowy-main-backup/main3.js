function changeMode(option) {
    //console.log(lock.id);
    if (option == "lock") {
      lock.style.display = "none";
      unlock.style.display = "block";
    } else {
      lock.style.display = "block";
      unlock.style.display = "none";
    }
  }
  
  function setCaret(el) {
    // var el = document.getElementById(id) || document.querySelector(id);
    var range = document.createRange();
    var sel = window.getSelection();
    range.setStart(el.childNodes[0], 0);
    range.collapse(true);
    sel.removeAllRanges();
    sel.addRange(range);
    el.focus();
  }
  
  const capitalize = (s) => {
    if (typeof s !== 'string') return ''
    return s.charAt(0).toUpperCase() + s.slice(1)
  }
  
  addEventListener('mousedown', (ev) => {
    if (!ev.target.closest('.setting-pick') && !ev.target.closest('.val-selector')) {
      const valSelectorHtmlElem = document.querySelector('.val-selector');
      valSelectorHtmlElem && (valSelectorHtmlElem.style.display = 'none');
    }
  });
  
  class App extends BinaryFlow {
    dragId = null;
    // url = 'https://valerii.educationhost.cloud?csurl=https://tastypoints.io/akm/restapi.php';
    url = 'https://tastypos.onprocess.work/tastypointsapi/testnet';
    sideElements = [];
    dragCloneElem = null;
    dx = null;
    dy = null;
    nodes = [];
    rightWindows = {};
    storiesDomElems = {};
    groups = [];
    globals = {
      globalVal1: 1234,
      someGlobalVariable: 'ass',
    }
  
    lastRightWindows = [];
  
    versions = {};
  
    flowNameElem = document.querySelector('#names .title');
    flowDescriptionElem = document.querySelector('#names .subtitle');
    flowActiveElem = document.querySelector('#active input');
  
    versionsElem = document.querySelector('#my-draw .menu ul');
  
    globalVars = {
      'bdate': 19027,
      'adate': 19041,
    };
  
    templateNode = {
      "flow_node_type_id": 2,
      "nodes_id": 0,
      "node_scrdata_id": 2002,
      "flow_action_scrdata_id": 78,
      "order": 1,
      "nodes_group_id": 3,
      "name": "**",
      "description": "**",
      "icon_link": "/tasty/vendor/Drawflowy-main/assets/eye.svg",
      "icon_link_selected": "/tasty/vendor/Drawflowy-main/assets/eyeblue.svg",
      "nodes_tooltip": "",
      "id_priority": 0,
      "active": 0,
      "execution_wait_time_seconds": 60000,
      "execute_node_specific_date_time": null,
      "loop_cycles": 1,
      "node_settings_json": {
        "if_checkout_amount_is_in_range": {
          "list_id": 0,
          "min": 0,
          "max": 0
        },
        "if_partner_is_in_group_id": {
          "list_id": 1,
          "partner_group_id": ""
        },
        "if_tasty_lover_is_in_group_id": {
          "list_id": 1,
          "tasty_lover_group_id": ""
        },
        "if_product_is_in_group_id": {
          "list_id": 1,
          "product_group_id": ""
        },
        "if_specific_partners_id_is": {
          "list_id": 1,
          "partners_id": [
            ""
          ]
        },
        "if_specific_tasty_lover_id_is": {
          "list_id": 1,
          "tasty_lover_id": [
            ""
          ]
        },
        "if_specific_product_id_is": {
          "list_id": 1,
          "product_id": [
            ""
          ]
        },
        "if_date_time_range_is": {
          "list_id": 4,
          "min": "",
          "max": ""
        }
      },
      "node_response_settings_json": {}
    };
  
    sortedStepKyes = {
      "id_nodes": 194,
      "node_scrdata_id": 2002,
      "flow_action_scrdata_id": 0,
      "flow_node_type_id": 1,
      "id_priority": 0,
      "node_position": 5,
      "name": "Send sms",
      "description": "Send welcome sms",
      "icon_link_selected": "/tasty/vendor/Drawflowy-main/assets/eyeblue.svg",
      "nodes_tooltip": "",
      "this_node_unique_id": 5,
      "prev_node_unique_id": 6,
      "next_node_unique_id": 0,
      "flow_lane_id": 4,
      "flow_step_x": 1548,
      "flow_step_y": 344,
      "condition_positive": 0,
      "condition_negative": 0,
      "loop_cycles": 1,
      "execution_wait_time_seconds": 60000,
      "execute_node_specific_date_time": "2021-04-30T10:00:00",
      "node_settings_json": {
        "settings": {
          "send_to_tid": [
            {
              "list_id": 0,
              "list_scrdata_id": 0,
              "tid": 0
            }
          ],
          "sms_template_id": {
            "list_id": 1,
            "list_scrdata_id": 0,
            "id": 1
          },
          "custom_message": {
            "sms_message": "",
            "originator_text": ""
          }
        },
        "jparam_settings": []
      },
      "node_response_settings_json": {}
    };
  
    constructor(...args) {
      super(...args);
  
    }
  
    async start() {
  
      const activeRightWindow = document.getElementById('my-draw');
      document.querySelectorAll('.col-right').forEach(el => {
        this.rightWindows[el.id] = el;
        if (el !== activeRightWindow) {
          el.parentNode.removeChild(el);
        }
      });
  
      super.start();
      this.loadFlow();
  
  
      this.quillEditor();
      this.setEvents();
  
      this.activeCategory = 'all';
      this.loadAllNodes().then(this.renderBlocks.bind(this));
      await this.renderGroups();
      // this.renderBlocks();
  
      // Object.keys(this.drawflow.drawflow).forEach(this.addQuillEditor.bind(this));
    }
  
    setRightWindow(id) {
      const domElem = this.rightWindows[id];
      const current = document.querySelector('.col-right');
      if (current !== domElem) {
        current.parentNode.removeChild(current);
        document.querySelector('body main').appendChild(domElem);
        this.lastRightWindows.push(current.id);
      }
    }
  
    async loadFlow() {
      const queryString = window.location.search;
      const urlParams = new URLSearchParams(queryString);
      // this.session_id = urlParams.get('session_id');
      this.session_id = document.querySelector('meta[name="session_id"]').content;
      if (!this.session_id) {
        console.error('session_id');
        return;
      }
  
      this.flow_id = parseInt(urlParams.get('flow_id'));
      if (!this.flow_id) {
        // create new flow
        this.request({
          "scrdata_id": 1163, item_id: 0, flows: [
            {
              flow_name: this.flowNameElem.innerText,
              flow_description: this.flowDescriptionElem.innerText,
              flow_active: this.flowActiveElem.checked ? 1 : 0,
            }
          ]
        }).then(({ item_id }) => {
          this.flow_id = item_id;
          // console.log(item_id);
          const url = new URL(window.document.URL);
          url.searchParams.set('flow_id', item_id);
          location.href = url.toString();
        });
        // location.();
      } else {
        this.request({ "scrdata_id": 1162, item_id: this.flow_id })
          .then(resp => {
            if (resp.flows === null) {
              alert('Such flow do not exist or was deleted!');
              return;
            }
            const flow = resp.flows[0];
            this.flowNameElem.innerText = flow.flow_name;
            this.flowDescriptionElem.innerText = flow.flow_description;
            this.flowActiveElem.checked = flow.flow_active;
            this.quill.setContents(JSON.parse(flow.flow_story));
          });
  
        const resp = await this.request({ "scrdata_id": 1160, item_id: this.flow_id });
        const flow_steps = resp.flow_steps;
        this.maxVersionNumber = flow_steps?.[0].update_version || 0;
  
        // setup for current
        this.loadSteps(flow_steps);
        const currentModuleElem = document.querySelector('[data-version="Home"]');
        currentModuleElem.onclick = () => {
          this.handleVersionClick(currentModuleElem);
          this.changeModule('Home');
        }
  
        this.rightWindows['my-draw'].querySelector('.btn-commit').onclick = this.commitSelectedFlow.bind(this);
  
        for (let versionNumber = this.maxVersionNumber; versionNumber > 0; --versionNumber) {
          await this.request({ "scrdata_id": 1160, item_id: this.flow_id, show_ver: versionNumber })
            .then(resp => this.initVersion(versionNumber, resp));
        }
      }
      document.querySelector('#publish').onclick = () => {
        // console.log('publish');
        const saveFlow = this.request({
          "scrdata_id": 1163, item_id: this.flow_id, flows: [{
            flow_id: this.flow_id,
            flow_name: this.flowNameElem.innerText,
            flow_description: this.flowDescriptionElem.innerText,
            flow_active: this.flowActiveElem.checked ? 1 : 0,
            flow_story: JSON.stringify(this.quill.getContents()).replaceAll("'", "''"),
            delete: 0,
          }]
        }).then(
          // console.log
        );
        const saveCommit = this.commitSelectedFlow();
        Promise.all([saveFlow, saveCommit]).then(
          () => alert('Saved')
        ).catch(err => alert(err.message));
      };
      document.querySelector('#publish').disabled = false;
  
      document.querySelector('#discard').onclick = () => {
        this.request({
          "scrdata_id": 1163, item_id: this.flow_id, flows: [{
            flow_id: this.flow_id,
            delete: 1,
          }]
        }).then(
          console.log
        );
      };
    }
  
    commitSelectedFlow() {
      // form rquest json
      const steps = this.drawflow.drawflow[this.module].data;
      if (Object.keys(steps).length === 0) {
        alert('Please add at least one nodes in flow to allow commit!');
        return;
      }
      // console.log(steps);
      ++this.maxVersionNumber;
      const flow_steps = Object.values(steps).map(step => {
        // console.log(step);
        let node = JSON.parse(JSON.stringify(step.data.node));
        node.update_version = this.maxVersionNumber;
  
        node.flow_node = {};
        ['name', 'description', 'icon_link_selected'].forEach(key => {
          node.flow_node[`node_${key}`] = node[key];
          delete node[key];
        });
        node.flow_node.node_tooltip = node.nodes_tooltip;
        delete node.nodes_tooltip;
        // console.log(node.flow_node);
        const data = this.getUpdatedStepData(step);
        // console.log(data);
        node = { ...node, ...data };
        return node;
      });
      // console.log(flow_steps);
      return this.request({ "scrdata_id": 1161, item_id: this.flow_id, flow_steps })
        .then((resp) => {
          if (resp.message) {
            alert(resp.message);
            console.log(resp.message);
            --this.maxVersionNumber;
          } else
            this.initVersion(this.maxVersionNumber, { flow_steps });
        });
    }
  
    getUpdatedStepData(step) {
      const { outputs: { output_1, output_2 } } = this.getNodeFromId(step.id);
      const data = {
        node_position: step.data.number,
        flow_lane_id: step.data.laneNumber,
        flow_step_x: step.pos_x,
        flow_step_y: step.pos_y,
        prev_node_unique_id: this.nodeParentId(step.id) ? this.getNodeFromId(this.nodeParentId(step.id)).data.node.this_node_unique_id : 0,
        next_node_unique_id: (!this.nodeIsCondition(step.id) && output_1.connections.length) ? this.getNodeFromId(output_1.connections[0].node).data.node.this_node_unique_id : 0,
        condition_positive: (this.nodeIsCondition(step.id) && output_1.connections.length) ? this.getNodeFromId(output_1.connections[0].node).data.node.this_node_unique_id : 0,
        condition_negative: (this.nodeIsCondition(step.id) && output_2.connections.length) ? this.getNodeFromId(output_2.connections[0].node).data.node.this_node_unique_id : 0,
      };
      return data;
    }
  
    async request(data) {
      let data_json = {
        "session_id": this.session_id,
        "sp_name": "OK",
        "session_exp": "2021-02-12T02:57:45.453422",
        "status": "OK",
        "item_id": 0,
        "max_row_per_page": 50,
        "search_term": "",
        "search_term_header": "",
        "pagination": 1,
        ...data
      };
      // console.log(data_json);
  
      // if (data_json.scrdata_id == 1161) console.log(JSON.stringify(data_json));
      // body: JSON.stringify({
      //   "input": data_json
      // }),
  
      let csrf_token = document.querySelector('meta[name="csrf-token"]').content;
    //   console.log(csrf_token);
  
      let formData = new FormData();
      formData.append("input",JSON.stringify(data_json));
  
  
      return fetch(this.url, {
        method: 'post',
        headers: {
            'X-CSRF-TOKEN': csrf_token,
        },
        body:formData,
      }).then(async resp => {
        let json = await resp.json();
        // console.log(json);
        if (json.status && json.data) {
          json = JSON.parse(json.data)
        } else {
          console.error(json);
        }
        if (json.response_error) {
          console.error(json.response_error);
        }
        return json;
      });
    }
  
    handleVersionClick(li) {
      if (!li.classList.contains('selected')) {
        document.querySelector('.menu .selected').classList.remove('selected');
        li.classList.add('selected');
      }
    }
  
    initVersion(versionNumber, resp) {
      // console.log(versionNumber);
      const flow_steps = resp.flow_steps.filter(({ update_version }) => update_version == versionNumber);
      this.versions[versionNumber] = flow_steps;
      const moduleName = `Version ${versionNumber}`;
      const li = document.createElement('li');
      li.style.order = -versionNumber;
      li.setAttribute('data-version', moduleName);
      li.innerHTML = `${moduleName}<span>:${flow_steps.length}</span>`;
      li.onclick = (ev) => {
        this.handleVersionClick(li);
        const allModules = Object.keys(this.drawflow.drawflow);
        if (!allModules.includes(moduleName)) {
          this.addModule(moduleName);
          this.changeModule(moduleName);
          this.loadSteps(flow_steps);
        } else {
          this.changeModule(moduleName);
        }
      };
      this.versionsElem.appendChild(li);
    }
  
    loadSteps(flow_steps) {
      this.idsRelations[this.module] = {};
  
      flow_steps?.forEach(step => {
        // console.log(step);
        ['name', 'description', 'icon_link_selected'].forEach(key => {
          step[key] = step.flow_node[`node_${key}`];
        });
        step.nodes_tooltip = step.flow_node.node_tooltip
        delete step.flow_node;
  
        const types = ['start', 'middle', 'condition', 'end'];
        this.addNode({
          name: step.name,
          type: types[step.flow_node_type_id % 4],
          pos: {
            x: step.flow_step_x,
            y: step.flow_step_y,
          },
          data: { node: step },
        });
      });
      const ids = this.idsRelations[this.module];
      // console.log(ids, this.idsRelations[this.module]);
      flow_steps?.forEach(({ prev_node_unique_id, this_node_unique_id, next_node_unique_id, condition_positive, condition_negative }) => {
        if (prev_node_unique_id) {
          this.addConnection(ids[prev_node_unique_id], ids[this_node_unique_id], 'output_1', 'input_1');
        }
        if (next_node_unique_id) {
          this.addConnection(ids[this_node_unique_id], ids[next_node_unique_id], 'output_1', 'input_1');
        }
        if (condition_positive) {
          this.addConnection(ids[this_node_unique_id], ids[condition_positive], 'output_1', 'input_1');
        }
        if (condition_negative) {
          this.addConnection(ids[this_node_unique_id], ids[condition_negative], 'output_2', 'input_1');
        }
      });
    }
  
    async loadAllNodes() {
      this.nodes = (await this.request({ "scrdata_id": 1156 })).flow_nodes || [];
    }
  
    async getTemplateNode(item_id) {
      return this.request({ "scrdata_id": 1156, item_id }).then(json => json.flow_nodes[0])
    }
  
    async updateTemplateNode(nodeData) {
      const index = this.nodes.findIndex(({ nodes_id }) => nodes_id === nodeData.nodes_id);
      if (index >= 0) {
        this.nodes[index] = nodeData;
        this.renderBlocks();
      }
      const resp = await this.request({ "scrdata_id": 1157, item_id: nodeData.nodes_id, flow_nodes: [nodeData] });
      
      console.log({ "scrdata_id": 1157, item_id: nodeData.nodes_id, flow_nodes: [nodeData] });
      console.log(resp);
  
      nodeData.nodes_id = resp.item_id;
      // console.log(nodeData.nodes_id);
      if (index === -1) {
        this.nodes.push(nodeData);
        this.renderBlocks();
      }
      if (nodeData.delete) {
        this.nodes = this.nodes.filter(({ nodes_id }) => nodes_id != nodeData.nodes_id);
        document.querySelector(`[data-nodes-id="${nodeData.nodes_id}"]`).style.display = 'none';
      }
  
      return nodeData;
    }
  
    renderGroup({ node_group_name, node_group_order, id }) {
      const groups = document.getElementById("subnav");
      const existGroup = groups.querySelector(`#category-${id}`);
      const group = existGroup ? existGroup : document
        .getElementById("group-template")
        .content.firstElementChild.cloneNode(true);
      group.id = `category-${id}`;
      group.innerText = node_group_name;
      group.style.order = node_group_order;
      if (!existGroup) {
        group.onclick = this.handleGroupClick.bind(this);
      }
      groups.appendChild(group);
    }
  
    handleGroupClick(e) {
      const category = e.target.closest('.category');
      if (!category.classList.contains("navactive")) {
        categories
          .querySelector(".navactive")
          .classList.replace("navactive", "navdisabled");
        category.classList.replace("navdisabled", "navactive");
        this.activeCategory = category.id;
        this.renderBlocks();
      }
    }
  
    async renderGroups() {
      const categories = document.getElementById("subnav");
      categories.innerHTML = '<div id="all" class="category navactive side">All</div>';
      this.groups = (await this.request({ "scrdata_id": 1154 })).flow_nodes_group;
  
      categories.querySelector('#all').onclick = this.handleGroupClick.bind(this);
      this.groups?.forEach(this.renderGroup.bind(this));
  
      categories.appendChild(document
        .getElementById("categories-ettings-template")
        .content.firstElementChild.cloneNode(true));
      // await this.renderBlocks();
  
      // switch between groups
      // categories.querySelectorAll('.category').forEach(category => {
      //   category
      // });
  
  
      document.getElementById('categories-settings').addEventListener('click', () => {
        const groupsSettings = document.getElementById('groups-settings');
        groupsSettings.style.display = 'block';
        const items = groupsSettings.querySelector('.items');
        items.innerHTML = ``;
        this.groups?.forEach(group => {
          items.appendChild(this.formGroupSettingDomElem(group));
        });
  
        groupsSettings.querySelector('.save').onclick = (ev) => {
          groupsSettings.querySelector('.save').disabled = true;
          items.querySelectorAll('.category-setting-item').forEach(async (group, inx, arr) => {
            const id = group.getAttribute('data-group');
            const node_group_name = group.querySelector('.category-title').innerText;
            const node_group_description = group.querySelector('.category-description').innerText;
            // console.log({ id, node_group_name, node_group_description });
            const data = { id, node_group_name, node_group_description };
            await this.updateGroup(data);
            if (inx === arr.length - 1) {
              await this.renderGroups();
              groupsSettings.querySelector('.save').disabled = false;
            }
          });
  
        };
  
        groupsSettings.querySelector('.add-category').onclick = async (ev) => {
          const newGroup = {
            id: 0,
            node_group_order: 99,
            node_group_name: 'New group',
            node_group_description: 'Group description'
          };
          newGroup.id = (await this.updateGroup(newGroup)).id;
          items.appendChild(this.formGroupSettingDomElem(newGroup));
        };
  
        groupsSettings.querySelector('.close').addEventListener('click', (ev) => {
          groupsSettings.style.display = 'none';
        });
      });
    }
  
    formGroupSettingDomElem({ node_group_name, node_group_order, id, node_group_description }) {
      const categorySettingItem = document.createElement('div');
      categorySettingItem.classList.add('category-setting-item');
      categorySettingItem.setAttribute('data-group', id)
      categorySettingItem.innerHTML = `
        <div>
          <h3 class="category-title" contenteditable="true">${node_group_name}</h3>
          <img class="edit-content" src="/tasty/vendor/Drawflowy-main/assets/edit-icon.svg" alt="">
          <span class="groupId">${id}</span>
          <button title="Tap and hold to delete" class="delete-category">Delete</button>
        </div>
        <div>
          <p class="category-description" contenteditable="true">${node_group_description}</p>
          <img class="edit-content" src="/tasty/vendor/Drawflowy-main/assets/edit-icon.svg" alt="">
        </div>`;
      categorySettingItem.querySelector('.delete-category').onclick = async () => {
        const confirm = window.confirm(`Do you really wanna delete group ${node_group_name}, ID.${id}`);
        if (confirm) {
          const data = { id, node_group_name, node_group_description, delete: 1 };
          categorySettingItem.parentNode.removeChild(categorySettingItem);
          await this.updateGroup(data);
          // console.log(this.activeCategory, id);
          if (this.activeCategory.slice(9) == id) {
            this.activeCategory = 'all';
            this.renderBlocks();
          }
        }
      };
      return categorySettingItem;
  
    }
  
    updateGroup(data) {
      // console.log(data.id);
      if (!('delete' in data)) {
        data.delete = 0;
      }
      return this.request({ "scrdata_id": 1155, "flow_nodes_group": [data], "item_id": data.id })
        .then(({ item_id }) => {
          if (data.delete || !data.id) {
            this.renderGroups();
          }
          return ({ id: item_id });
        });
    }
  
    renderNodeSettings({ nodeData, jsonEditor }) {
      // console.log(nodeData);
  
      // order keys
      Object.keys(this.sortedStepKyes).forEach(key => {
        if (key in nodeData) {
          // console.log(key);
          const value = nodeData[key];
          delete nodeData[key];
          nodeData[key] = value;
        }
      });
  
  
      this.setRightWindow('node-settings');
      const win = document.getElementById('node-settings');
      if (!jsonEditor) {
        const container = win.querySelector(".jsoneditor");
        container.innerHTML = '';
        const options = {
          mode: "tree",
          modes: ['code', 'form', 'text', 'tree', 'view', 'preview'],
          onChange: () => {
            const newData = jsonEditor.get();
            for (let key in nodeData) {
              if (!(key in newData)) {
                delete nodeData[key];
              }
            }
            for (let key in newData) {
              nodeData[key] = newData[key];
            }
            this.renderNodeSettings({ nodeData, jsonEditor });
          },
        };
        jsonEditor = new JSONEditor(container, options);
        jsonEditor.set(nodeData);
      }
  
      const header = document.createElement('header');
  
      const types = {
        "number": [
          "nodes_id",
          "node_scrdata_id",
          "flow_action_scrdata_id",
          "order",
          "nodes_group_id",
          "flow_node_type_id",
          "id_priority",
          "active",
          "execution_wait_time_seconds",
          "loop_cycles",
          "flow_step_x",
          "flow_step_y",
          "prev_node_unique_id",
          "next_node_unique_id",
          "this_node_unique_id",
          "update_version",
          "id",
          "flow_lane_id",
          "node_position",
          "condition_positive",
          "condition_negative",
        ],
        "text": [
          "name",
          "description",
          "icon_link",
          "icon_link_selected",
          "nodes_tooltip",
        ],
        "datetime-local": [
          "execute_node_specific_date_time",
        ],
      };
      let props = {};
      Object.keys(types).forEach(key => {
        types[key].forEach(prop => props[prop] = key);
      });
  
      const left = win.querySelector('.left');
      left.innerHTML = `
        <div class="control">
          <button class="btn execute">Execute</button>
          <button class="btn save">Save</button>
          <button class="btn delete">Delete</button>
        </div>
        <div class="val-selector">
        </div>`;
  
      const createSettingItem = (pathArr, key, obj) => {
        const value = obj[key];
        const type = (typeof value) === 'string' ? 'text' : (typeof value);
        const settingItemInfo = document.createElement('div');
        settingItemInfo.classList.add("setting-item-info");
        settingItemInfo.innerHTML = `
                  <label>${key}:</label>
                  <span class="setting-right">
                    <input class="static" class="${key}" value="${value}" type="${type}">
                    <label class="setting-pick">
                      <input type="radio" name="val-selector">
                      <img src="/tasty/vendor/Drawflowy-main/assets/setting.svg">
                    </label>
                  </span>`;
  
        // console.log(settingItemInfo);
        settingItemInfo.querySelector(`.static`).oninput = ev => {
          obj[key] = (ev.target.type === 'number' || type === 'number') ? parseInt(ev.target.value) : ev.target.value;
          jsonEditor.set(nodeData);
          jsonEditor.expandAll();
        };
        if (pathArr[0] === 'Settings JSON') {
          this.activateSelector([...pathArr, key], settingItemInfo, nodeData, jsonEditor);
        }
        return settingItemInfo;
      };
  
      const createSettingsHtml = (pathArr, obj) => {
        const defKeys = ["list_id", "list_scrdata_id"];
        const container = document.createElement('details');
        container.innerHTML = `<summary>${pathArr[pathArr.length - 1]}</summary>`;
        for (let key in obj) {
          if (defKeys.includes(key)) {
            continue;
          }
          if (typeof obj[key] !== 'object') {
            const settingItem = createSettingItem(pathArr, key, obj);
            container.appendChild(settingItem);
          } else {
            const nestedObj = createSettingsHtml([...pathArr, key], obj[key]);
            container.appendChild(nestedObj);
          }
        }
        return container;
      };
  
      const responseJSON = createSettingsHtml(['Response JSON'], nodeData.node_response_settings_json);
      left.prepend(responseJSON);
  
      const settingsJSON = createSettingsHtml(['Settings JSON'], nodeData.node_settings_json);
      left.prepend(settingsJSON);
  
  
      const defaultSettings = document.createElement('details');
      defaultSettings.open = true;
      defaultSettings.innerHTML = `<summary>Default settings</summary><div class="info"></div>`;
      left.prepend(defaultSettings);
      const info = defaultSettings.querySelector('.info');
  
      for (let key in nodeData) {
        if (typeof nodeData[key] !== 'object' || nodeData[key] === null) {
          const label = document.createElement('label');
  
          const keyName = capitalize(key.replace(/_/g, ' '));
          // console.log(key, keyName, nodeData[key]);
          label.innerHTML = `${keyName}:
            <input class="${key}" type="${props[key]}" value="${nodeData[key]}" placeholder="${keyName}">`;
  
          if (key === 'execute_node_specific_date_time') {
            label.innerHTML += `<button class="reset-datetime">Reset</button>`;
            label.querySelector('.reset-datetime').onclick = () => {
              nodeData[key] = null;
              jsonEditor.set(nodeData);
              label.querySelector(`input.${key}`).value = null;
            }
          }
  
          if (key === "flow_node_type_id") {
            label.innerHTML = `Node type:
            <select class="flow_node_type_id">
              <option value="0">Start</option>
              <option value="1">Middle</option>
              <option value="2">Condition</option>
              <option value="3">End</option>
            </select>`;
            label.querySelector(`option[value="${nodeData[key]}"]`)?.setAttribute('selected', true);
          }
          if (key === "nodes_group_id") {
            label.innerHTML = `Group: <select class="nodes_group_id"><option value="0">All</option></select>`;
            const select = label.querySelector('select');
            this.groups?.forEach(({ id, node_group_name }) => {
              select.innerHTML += `<option value="${id}">${node_group_name}</option>`;
            });
            if (nodeData[key] && label.querySelector(`option[value="${nodeData[key]}"]`)) {
              label.querySelector(`option[value="${nodeData[key]}"]`).setAttribute('selected', true);
            }
          }
  
          if (key === "active") {
            label.innerHTML = `Active: <label class="switch">
            <input class="active" type="checkbox" />
            <span class="slider"></span>
          </label>`;
            if (nodeData[key]) {
              label.querySelector('input').checked = true;
            }
          }
  
          info.appendChild(label);
        }
      }
      info.querySelector('.nodes_id')?.setAttribute('disabled', true);
      info.querySelector('.id_nodes')?.setAttribute('disabled', true);
      if (nodeData.this_node_unique_id) {
        ['save', 'delete'].forEach(className => win.querySelector(`.control .${className}`).style.display = 'none');
        [
          "flow_node_type_id",
          "nodes_group_id",
          "this_node_unique_id",
          "flow_step_x",
          "flow_step_y",
          "prev_node_unique_id",
          "next_node_unique_id",
          "update_version",
          "id",
          "flow_lane_id",
          "node_position",
          "condition_positive",
          "condition_negative",
  
        ].forEach((key) =>
          info.querySelector(`.${key}`)?.setAttribute("disabled", true)
        );
      }
  
      // set handlers to update data
      let maxInputWidth = 0;
      info.querySelectorAll('input, select').forEach(input => {
        maxInputWidth = Math.max(maxInputWidth, parseInt(getComputedStyle(input).width));
        input.oninput = ev => {
          if (input.classList[0] === 'active')
            nodeData[input.classList[0]] = (ev.target.checked) ? 1 : 0;
          else
            nodeData[input.classList[0]] = types.number.includes(input.classList[0]) ? parseInt(ev.target.value) : ev.target.value;
          jsonEditor.set(nodeData);
          header.innerHTML = `
            <img src="${nodeData.icon_link_selected}">
            <div>
              <div class="title">${nodeData.name}</div>
              <div class="description">${nodeData.description}</div>
            </div>`;
        };
      });
      // Set max width to inputs e. g. align inputs
      info.querySelectorAll('input, select').forEach(input => input.style.width = maxInputWidth + 'px');
  
      win.querySelector('.save').onclick = ev => {
        nodeData.delete = 0;
        console.log(nodeData);
        this.updateTemplateNode(nodeData);
      };
      win.querySelector('.delete').onclick = ev => {
        const confirm = window.confirm(`Do you really wanna delete node ${nodeData.name}, ID.${nodeData.nodes_id}`);
        if (confirm) {
          nodeData.delete = 1;
          this.updateTemplateNode(nodeData);
          this.setRightWindow("my-draw");
        }
      };
  
  
      header.innerHTML = `
            <img src="${nodeData.icon_link_selected}">
            <div>
              <div class="title">${nodeData.name}</div>
              <div class="description">${nodeData.description}</div>
            </div>`;
      left.prepend(header);
    }
  
    activateSelector(pathArrEx, settingItemInfo, nodeData, jsonEditor) {
      // val selector
      const nodeSettingsJSON = nodeData.node_settings_json;
      if (!nodeSettingsJSON.jparam_settings) {
        nodeSettingsJSON.jparam_settings = [];
      }
  
      const pickImg = settingItemInfo.querySelector('.setting-pick');
      const checkbox = pickImg.querySelector('input');
      pickImg.addEventListener('click', () => {
        const valSelectorHtmlElem = document.querySelector('.val-selector');
        valSelectorHtmlElem.innerHTML = `
            <p>Variable selector</p>
            <details id="global-vars">
              <summary>Global variables</summary>
            </details>`;
        if (!checkbox.checked) {
          valSelectorHtmlElem.style.display = 'none';
          return;
        }
        // settingsItem.querySelector('.setting-pick')
        valSelectorHtmlElem.style.display = 'inline-block';
        const {
          top,
          left
        } = pickImg.getBoundingClientRect();
        valSelectorHtmlElem.style.left = left + window.scrollX + pickImg.offsetWidth + 'px';
        valSelectorHtmlElem.style.top = top + window.scrollY + 'px';
  
        // global vars
        const globalVarsPicker = valSelectorHtmlElem.querySelector('#global-vars');
        globalVarsPicker.addEventListener('toggle', () => {
          if (globalVarsPicker.open) {
            for (let key in this.globalVars) {
              const value = this.globalVars[key];
              const dl = document.createElement('dl');
              dl.innerHTML = `
                <img src="/tasty/vendor/Drawflowy-main/assets/plus.svg">
                <dt>${key}:</dt>
                <dd>${value}</dd>`;
              globalVarsPicker.appendChild(dl);
            }
          }
        });
  
        const createSettingItem = (pathArr, key, obj, node_unique_id) => {
          if (!node_unique_id) {
            node_unique_id = nodeData.prev_node_unique_id;
          }
          const value = obj[key];
          const type = (typeof value) === 'string' ? 'text' : (typeof value);
          const settingItemInfo = document.createElement('dl');
          settingItemInfo.classList.add('setting-item-choose');
          settingItemInfo.innerHTML = `
                    <img src="/tasty/vendor/Drawflowy-main/assets/plus.svg">
                    <dt>${key}:</dt>
                    <dd>${value}</dd>`;
          settingItemInfo.querySelector('img').onclick = () => {
            const newParam = {
              "replace_this_element": pathArrEx.slice(1).join(','),
              "replace_tag": "",
              "with_this_element_value": {
                "node_unique_id": node_unique_id,
                "settings": pathArr[1] === 'node_settings_json' ? 1 : 0,
                "parameter": [...pathArr, key].slice(2).join(','),
              }
            };
            console.log(newParam);
  
            nodeSettingsJSON.jparam_settings = nodeSettingsJSON.jparam_settings
              .filter(({ replace_this_element }) => replace_this_element !== newParam.replace_this_element);
            nodeSettingsJSON.jparam_settings.push(newParam);
            newParam.replace_tag = `&%jparam:${nodeData.this_node_unique_id}:${nodeSettingsJSON.jparam_settings.length - 1}%&`;
            jsonEditor.set(nodeData);
            this.renderNodeSettings({ nodeData, jsonEditor });
            jsonEditor.expandAll();
          };
          return settingItemInfo;
        };
  
        const createSettingsHtml = (pathArr, obj, node_unique_id) => {
          const defKeys = [];
          const container = document.createElement('details');
          container.innerHTML = `<summary>${pathArr[pathArr.length - 1]}</summary>`;
          for (let key in obj) {
            if (defKeys.includes(key)) {
              continue;
            }
            if (typeof obj[key] !== 'object') {
              const settingItem = createSettingItem(pathArr, key, obj, node_unique_id);
              container.appendChild(settingItem);
            } else {
              const nestedObj = createSettingsHtml([...pathArr, key], obj[key], node_unique_id);
              container.appendChild(nestedObj);
            }
          }
          return container;
        };
  
        // previous node
        if (nodeData.prev_node_unique_id) {
          const previousNodeId = this.idsRelations[this.module][nodeData.prev_node_unique_id];
          const previousNodeData = this.getNodeFromId(previousNodeId).data;
          const title = `${previousNodeData.node.name} #${previousNodeData.number} : ${previousNodeData.node.this_node_unique_id}`;
          const { node_settings_json, node_response_settings_json } = previousNodeData.node;
          const previousNodePicker = createSettingsHtml([title], { node_settings_json, node_response_settings_json }, previousNodeData.node.this_node_unique_id);
          const details = document.createElement('details');
          details.innerHTML = `<summary>Previous node</summary>`;
          details.appendChild(previousNodePicker);
          valSelectorHtmlElem.appendChild(details);
        }
  
        // all previous nodes
        const previousNodes = document.createElement('details');
        previousNodes.innerHTML = `<summary>Previous nodes</summary>`;
        let tmpData = nodeData;
        while (tmpData.prev_node_unique_id) {
          // console.log(tmpData.this_node_unique_id);
          const previousNodeId = this.idsRelations[this.module][tmpData.prev_node_unique_id];
          const previousNodeData = this.getNodeFromId(previousNodeId).data;
          const title = `${previousNodeData.node.name} #${previousNodeData.number} : ${previousNodeData.node.this_node_unique_id}`;
          const { node_settings_json, node_response_settings_json } = previousNodeData.node;
          const previousNodePicker = createSettingsHtml([title], { node_settings_json, node_response_settings_json }, previousNodeData.node.this_node_unique_id );
          previousNodes.appendChild(previousNodePicker);
          tmpData = previousNodeData.node;
        }
        valSelectorHtmlElem.appendChild(previousNodes);
  
  
      });
  
    }
  
    renderBlock({
      description,
      icon_link,
      icon_link_selected,
      name,
      order,
      nodes_id
    }) {
      const blocklist = document.querySelector("#blocklist");
      const existBlock = blocklist.querySelector(`[data-nodes-id="${nodes_id}"]`);
      const domElem = existBlock ? existBlock : document
        .getElementById("sideElem")
        .content.firstElementChild.cloneNode(true);
      domElem.querySelector(".blocktitle").innerText = name;
      domElem.querySelector(".blockdesc").innerText = description;
      domElem.querySelector(".blockico > img").src = icon_link;
      domElem.style.order = order;
      if (existBlock) return;
      domElem.querySelector(".side-elem-more").addEventListener('click', async () => {
        // console.log('click');
  
        let nodeData = await this.getTemplateNode(nodes_id);
        this.renderNodeSettings({ nodeData });
      });
      const dragBegin = (ev) => {
        if (ev.target.closest('.side-elem-more')) {
          // console.log(ev.target.closest('.side-elem-more'));
          return;
        }
        let clientX, clientY;
        if (ev.type === "touchstart") {
          clientX = ev.touches[0].clientX;
          clientY = ev.touches[0].clientY;
        } else {
          clientX = ev.clientX;
          clientY = ev.clientY;
        }
        this.dragId = nodes_id;
        domElem.classList.add("blockdisabled");
        this.dx = clientX - domElem.getBoundingClientRect().left;
        this.dy = clientY - domElem.getBoundingClientRect().top;
  
        this.dragCloneElem = domElem.cloneNode(true);
        this.dragCloneElem.style.position = "absolute";
        this.dragCloneElem.style.left =
          clientX - this.dx + window.scrollX + "px";
        this.dragCloneElem.style.top =
          clientY - this.dy + window.scrollY + "px";
        this.dragCloneElem.style.zIndex = "20";
        document.body.appendChild(this.dragCloneElem);
      };
      domElem.addEventListener("mousedown", dragBegin);
      domElem.addEventListener("touchstart", dragBegin);
      domElem.setAttribute('data-nodes-id', nodes_id);
      blocklist.appendChild(domElem);
    }
  
    get activeNodes() {
      if (this.activeCategory === 'all') {
        return this.nodes;
      } else {
        const groupActiveId = this.activeCategory.slice(9);
        return this.nodes.filter(({ nodes_group_id }) => nodes_group_id == groupActiveId);
      }
    }
  
    renderBlocks(searchText) {
      let activeNodes = this.activeNodes;
      if (searchText) {
        activeNodes = activeNodes.filter(({ name, description }) =>
          name.toUpperCase().includes(searchText.toUpperCase()) || description.toUpperCase().includes(searchText.toUpperCase()));
      }
  
      const blocklist = document.querySelector("#blocklist");
      blocklist.innerHTML = '';
      activeNodes?.forEach(this.renderBlock.bind(this));
    }
  
    addNode(...args) {
      const id = super.addNode(...args);
  
      this.stepClickMoreHandle(id);
      return id;
    }
  
    addNodeImport(...args) {
      super.addNodeImport(...args);
      this.stepClickMoreHandle(args[0].id);
    }
  
    stepClickMoreHandle(id) {
      this.nodeHtmlElem(id).querySelector('.blockyright').addEventListener('click', e => {
        let nodeData = this.drawflow.drawflow[this.module].data[id].data.node;
        const data = this.getUpdatedStepData(this.drawflow.drawflow[this.module].data[id]);
        for (let key in data) {
          nodeData[key] = data[key];
        }
  
        this.renderNodeSettings({ nodeData });
      });
    }
  
    initNodeTemplate() {
      const win = this.rightWindows['nodeTemplate'];
      const container = win.querySelector(".jsoneditor");
      container.innerHTML = '';
      const options = {
        mode: "tree",
        modes: ['code', 'form', 'text', 'tree', 'view', 'preview'],
        onChange: () => {
          this.templateNode = jsonEditor.get();
          console.log(this.templateNode);
        },
      };
      const jsonEditor = new JSONEditor(container, options);
      jsonEditor.set(this.templateNode);
    }
  
    setEvents() {
      document.querySelector('#back').onclick = () => {
        console.log(this.lastRightWindows);
        const lastRightWindowId = this.lastRightWindows.pop();
        if (lastRightWindowId) {
          this.setRightWindow(lastRightWindowId);
        }
      };
  
      const updateCountSteps = () => {
        const allModules = Object.keys(this.drawflow.drawflow);
        allModules.forEach(moduleName =>
          document.querySelector(`[data-version="${moduleName}"] span`)
            .innerText = `:${Object.keys(this.drawflow.drawflow[moduleName].data).length}`)
      };
      this.on('nodeCreated', updateCountSteps);
      this.on('nodeRemoved', updateCountSteps);
  
  
      this.initNodeTemplate();
      document.getElementById('add-block').addEventListener('click', async (ev) => {
        if (ev.target.closest('.blockyright')) {
          console.log('more . . .');
          this.setRightWindow('nodeTemplate');
          return;
        }
        const template = JSON.parse(JSON.stringify(this.templateNode));
        template.name += ` ${this.nodes.length}`;
        let maxOrder = 0;
        this.nodes.forEach(({ order }) => maxOrder = Math.max(maxOrder, order));
        template.order = maxOrder + 1;
        template.nodes_group_id = parseInt(this.activeCategory.slice(9));
        const { nodes_id } = await this.updateTemplateNode(template);
        document.querySelector(`.blockelem[data-nodes-id="${nodes_id}"]`).querySelector('.side-elem-more').click();
      });
  
  
      document.getElementById('search').addEventListener('input', (ev) => {
        console.log(ev.target.value);
        this.renderBlocks(ev.target.value);
      });
  
      document.getElementById("closecard").addEventListener("click", () => {
        document.getElementById("leftcard").style.display = "none";
      });
      document.getElementById("opencard").addEventListener("click", () => {
        document.getElementById("leftcard").style.display = "block";
      });
  
      document.addEventListener("mouseup", this.dragFinish.bind(this));
      document.addEventListener("touchend", this.dragFinish.bind(this));
  
      document.addEventListener("mousemove", this.dragMove.bind(this));
      document.addEventListener("touchmove", this.dragMove.bind(this));
      document.addEventListener('click', () => {
        document.querySelectorAll('img.edit-content').forEach(img => {
          img.addEventListener('click', (e) => {
            // console.log(img.previousElementSibling);
            setCaret(img.previousElementSibling);
          });
        });
      });
  
  
  
      document.getElementById("rightswitch").addEventListener("click", () => {
        this.setRightWindow("jsoneditor");
        const container = document.getElementById("jsoneditor");
        container.innerHTML = '';
        const options = {
          mode: "view",
          onChangeJSON: (json) => {
            this.import(json);
          },
        };
        const jsonEditor = new JSONEditor(container, options);
        jsonEditor.set(this.export());
        jsonEditor.expandAll();
      });
  
      document.querySelector(".btn-story").addEventListener("click", () => {
        this.setRightWindow('flowStory');
      });
      document.getElementById("leftswitch").addEventListener("click", () => {
        this.setRightWindow("my-draw");
        this.updateAllFlows();
      });
    }
  
    quillEditor() {
      function loadFonts() {
        window.WebFontConfig = {
          google: {
            families: [
              "Inconsolata::latin",
              "Ubuntu+Mono::latin",
              "Slabo+27px::latin",
              "Roboto+Slab::latin",
            ],
          },
        };
        (function () {
          var wf = document.createElement("script");
          wf.src = "https://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js";
          wf.type = "text/javascript";
          wf.async = "true";
          var s = document.getElementsByTagName("script")[0];
          s.parentNode.insertBefore(wf, s);
        })();
      }
      var fonts = ["sofia", "slabo", "roboto", "inconsolata", "ubuntu"];
      var Font = Quill.import("formats/font");
      Font.whitelist = fonts;
      Quill.register(Font, true);
  
      // const domElem = document
      //   .getElementById("quill-template")
      //   .content.firstElementChild.cloneNode(true);
      // domElem.setAttribute('data-quill-editor', moduleName);
      // this.storiesDomElems[moduleName] = domElem;
  
      const domElem = this.rightWindows['flowStory'];
  
      this.quill = new Quill(domElem.firstElementChild, {
        bounds: "#toolbar",
        modules: {
          syntax: true,
          toolbar: [
            [{
              font: fonts
            }, {
              size: []
            }],
            ["bold", "italic", "underline", "strike"],
            [{
              color: []
            }, {
              background: []
            }],
            [{
              script: "super"
            }, {
              script: "sub"
            }],
            [{
              header: "1"
            }, {
              header: "2"
            }, "blockquote", "code-block"],
            [{
              list: "ordered"
            },
            {
              list: "bullet"
            },
            {
              indent: "-1"
            },
            {
              indent: "+1"
            },
            ],
            [{
              direction: "rtl"
            }, {
              align: []
            }],
            ["link", "image", "video", "formula"],
            ["clean"],
          ],
        },
        theme: "snow",
      });
      loadFonts();
    }
  
    dragMove(ev) {
      if (this.dragId === null) {
        if (ev.type === "touchmove") this.position(ev);
        return;
      }
  
      let clientX, clientY;
      if (ev.type === "touchmove") {
        clientX = ev.touches[0].clientX;
        clientY = ev.touches[0].clientY;
      } else {
        clientX = ev.clientX;
        clientY = ev.clientY;
      }
  
      this.dragCloneElem.style.left = clientX - this.dx + window.scrollX + "px";
      this.dragCloneElem.style.top = clientY - this.dy + window.scrollY + "px";
      if (document.getElementById('my-draw')) {
        const { top, left } = document.querySelector('.drawflow').getBoundingClientRect();
        if (this.editor_mode === "fixed" || clientX < left || clientY < top) {
          return false;
        }
        const x =
          clientX *
          (this.precanvas.clientWidth /
            (this.precanvas.clientWidth * this.zoom)) -
          this.precanvas.getBoundingClientRect().x *
          (this.precanvas.clientWidth /
            (this.precanvas.clientWidth * this.zoom));
        const y =
          (clientY - this.dy) *
          (this.precanvas.clientHeight /
            (this.precanvas.clientHeight * this.zoom)) -
          this.precanvas.getBoundingClientRect().y *
          (this.precanvas.clientHeight /
            (this.precanvas.clientHeight * this.zoom));
  
        const node = JSON.parse(JSON.stringify(this.activeNodes.find(({ nodes_id }) => nodes_id === this.dragId)));
        node.id_nodes = node.nodes_id;
        ['order', 'active', 'icon_link', 'nodes_group_id', 'nodes_id']
          .forEach(key => delete node[key]);
  
        this.dragCloneElem.remove();
        document.querySelector('.blockdisabled')?.classList.remove("blockdisabled");
  
        // check if start
        if (node.flow_node_type_id === 0) {
          const nodes = Object.values(this.drawflow.drawflow[this.module].data);
          console.log(nodes);
          for (let key in nodes) {
            console.log(nodes[key]);
            const { data: { node: { flow_node_type_id } } } = nodes[key];
            if (flow_node_type_id === 0) {
              alert('Start node already exist!');
              this.dragId = null;
              return;
            }
          }
        }
  
        const newNodeId = this.addNewNode({ pos: { x, y }, node });
  
        this.click({
          target: this.nodeHtmlElem(newNodeId),
          touches: ev.touches,
          type: ev.type,
          clientX,
          clientY,
        }); // mousedown, touchstart on node
        this.dragId = null;
      }
    }
  
    dragFinish() {
      this.dragId = null;
      if (this.dragCloneElem) this.dragCloneElem.remove();
      document.querySelector('.blockdisabled')?.classList.remove("blockdisabled");
    }
  }
  
  var id = document.getElementById("drawflow");
  const editor = new App(id);
  editor.start();