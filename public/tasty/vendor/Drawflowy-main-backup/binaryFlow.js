class BinaryFlow extends Drawflow {
    spacing_y = 30;
    spacing_x = 40;
    distanceToDisconnect = 0;
    distanceToConnect = 100;
    idsRelations = {};
    nodeTypes = { "start": [0, 1], "middle": [1, 1], "condition": [1, 2], "end": [1, 0] }

    constructor(...args) {
        super(...args);
        this.on('connectionCreated', this.onConnectionCreated.bind(this));

        this.on('connectionCreated', this.updateAllFlows.bind(this));
        this.on('connectionRemoved', this.updateAllFlows.bind(this));
        this.on('nodeRemoved', this.updateAllFlows.bind(this));
        this.on('nodeCreated', this.updateAllFlows.bind(this));

        this.indicator = document.createElement('div');
        this.indicator.classList.add('indicator', 'invisible');
    }

    addNode({ name, type, pos: { x, y }, data }) {
        // set this_node_unique_id

        // console.log(data.node.this_node_unique_id)

        // mock data for response
        // data.node.node_response_settings_json = {
        //     "executed_date_time": "0000.00.00t00.00.00",
        //     "execution_duration": 2,
        //     "next_node_unique_id": 62,
        //     "is_positive": 1
        // };

        let newNodeId = null;
        name = name || 'default';
        const html = this.createNodeHtml({ id: this.nodeId, data });
        if (this.nodeTypes[type]) {
            newNodeId = super.addNode(name, ...this.nodeTypes[type], x, y, type, data, html);
            this.idsRelations[this.module][data.node.this_node_unique_id] = newNodeId;
        }
        // this.renderNode(newNodeId);
        return newNodeId;
    }

    addNewNode({ pos, node }) {
        const { name, flow_node_type_id } = node;
        const types = ['start', 'middle', 'condition', 'end'];
        const reducer = (a, b) => Math.max(a, b.data.node.this_node_unique_id);
        const allNodes = Object.values(this.drawflow.drawflow[this.module].data);
        node.this_node_unique_id = allNodes.reduce(reducer, 0) + 1;
        node.prev_node_unique_id = 0;
        node.next_node_unique_id = 0;
        const type = types[flow_node_type_id % 4];

        const newNodeId = this.addNode({
            name,
            type,
            pos,
            data: { node },
        });
        // console.log(newNodeId);
        return newNodeId;
    }

    addNodeImport(...args) {
        super.addNodeImport(...args);
        this.renderNode(args[0].id);
    }

    load() {
        super.load();
        document.querySelectorAll('svg.connection').forEach(svg => {
            const nodeOutId = svg.classList[2].slice(14);
            if (this.nodeIsCondition(nodeOutId)) {
                svg.classList.add('out-condition-connection');
            };
        });
        this.updateAllFlows();
    }

    onConnectionCreated(info) {
        // restrict connections
        const len_output_connections = this.getNodeFromId(info.output_id).outputs[info.output_class].connections.length;
        const len_input_connections = this.getNodeFromId(info.input_id).inputs[info.input_class].connections.length;
        if (len_output_connections > 1 || len_input_connections > 1) {
            this.removeSingleConnection(...Object.values(info));
        } else {
            // if coonnection crration is allowed:

            // color condition outputs
            if (this.nodeIsCondition(info.output_id)) {
                document.querySelector(`svg.connection.${info.output_class}.node_out_node-${info.output_id}`).classList.add('out-condition-connection');
            }
        }
    }

    updateNode(id, info = {}, render = false) {
        const currentInfo = this.getNodeFromId(id);
        const nodeElem = document.getElementById(`node-${id}`);
        this.drawflow.drawflow[this.module].data[id] = _.merge(currentInfo, info);
        ('pos_x' in info) && (nodeElem.style.left = info.pos_x + 'px');
        ('pos_y' in info) && (nodeElem.style.top = info.pos_y + 'px');
        this.updateConnectionNodes(`node-${id}`);
        if (render) {
            this.renderNode(id);
            const headNodeId = this.getHeadOfFlow(id);
            this.elemFlowHeight(headNodeId);
            this.align(headNodeId);
        }
    }

    renderNode(id) {
        const { data: { node: { name, description, icon_link_selected } } } = this.getNodeFromId(id);
        const nodeHtml = this.nodeHtmlElem(id).querySelector('.drawflow_content_node');
        nodeHtml.querySelector('.blockyleft img').src = icon_link_selected;
        nodeHtml.querySelector('.blockyname').innerText = name;
        nodeHtml.querySelector('.blockyinfo').innerText = description;
        this.drawflow.drawflow[this.module].data[id].html = nodeHtml.innerHTML;
    }

    createNodeHtml({ id, data: { node: { nodes_id, name, description, number, flow_node_type_id, icon_link_selected } } }) {
        // const debugHtml = `
        //     <span class="id"></span>
        //     <span class="flow-height"></span>
        //     <span class="simple-flow-height"></span>
        //     <span class="elem-height"></span>

        //     <span class="name"></span>
        //     `;
        const html = `
<div class="blockelem create-flowy noselect">
    <div class='blockyleft noselect'>
        <img class='noselect' draggable='false' src='${icon_link_selected}'>
        <p class='blockyname noselect'>${name}</p>
    </div>
    <div class='blockyright'>
        <img src='/tasty/vendor/Drawflowy-main/assets/more.svg'>
    </div>
    <div class='blockydiv'></div>
    <div class='blockyinfo noselect'>${description}</div>
</div>
<span class="node-num">${number} : ${id}</span>
    `;
        return html;
    }

    isSimpleFlow(nodeId) {
        // return last node id if flow is simple else returns false;
        let nodeInfo = this.getNodeFromId(nodeId);
        let outputs = nodeInfo.outputs;
        while (!outputs.output_2 && outputs.output_1?.connections.length) {
            nodeInfo = this.getNodeFromId(outputs.output_1.connections[0].node);
            outputs = nodeInfo.outputs;
        }
        return outputs.output_2 ? false : nodeInfo.id;
    }

    findAllFlows() {
        const allNodes = this.drawflow.drawflow[this.module].data;
        const flows = [];
        for (const nodeId in allNodes) {
            const { inputs } = this.getNodeFromId(nodeId);
            if (!inputs.input_1 || !inputs.input_1.connections.length) {
                flows.push(nodeId);
            }
        }
        return flows;
    }

    nodeAllOutConnections(nodeId) {
        const { outputs } = this.getNodeFromId(nodeId);
        const children = [];
        Object.values(outputs).forEach(output => {
            if (output.connections.length)
                children.push(output.connections[0]);
        });
        return children;
    }

    setLaneNumbers() {
        const allFlows = this.findAllFlows();
        let laneNodes = allFlows.map(id => ({ id, flow: id }));
        let laneNumber = 0;
        while (laneNodes.length > 0) {
            const nextLaneNodes = [];
            for (const { id, flow } of laneNodes) {
                this.updateNode(id, { data: { laneNumber, flow } });
                nextLaneNodes.push(...this.nodeAllOutConnections(id).map(conn => ({ id: conn.node, flow })));
            }
            ++laneNumber;
            laneNodes = nextLaneNodes;
        }
    }

    updateAllFlows() {
        this.setLaneNumbers();
        const allFlows = this.findAllFlows();
        const allNodes = Object.values(this.drawflow.drawflow[this.module].data);
        allFlows.forEach(flow => {
            const flowNodes = allNodes.filter(node => node.data.flow === flow);
            let number = 0;
            let laneNumber = 0;
            // all nodes in lane
            let laneNodes = flowNodes.filter(node => node.data.laneNumber === laneNumber);
            while (laneNodes.length > 0) {
                laneNodes.forEach(node => this.updateNode(node.id, { data: { number: number++ } }));
                laneNumber++;
                laneNodes = flowNodes.filter(node => node.data.laneNumber === laneNumber);
            }
        });
        this.renderNodes();
        // align all flows
        allFlows.forEach(flow => {
            this.elemFlowHeight(flow);
            this.align(flow);
        })
    }

    renderNodes() {
        const allNodes = Object.values(this.drawflow.drawflow[this.module].data);
        allNodes.forEach(node => {
            this.renderNode(node.id);
            const htmlElem = this.nodeHtmlElem(node.id);
            // htmlElem.querySelector(`.id`).innerText = `Id: `;
            htmlElem.querySelector(`.node-num`).innerText = `#${node.data.number} : ${node.data.node.this_node_unique_id}`;
            // htmlElem.querySelector(`.flow-height`).innerText = `flow-height : ${node.data.flowHeight}`;
            // htmlElem.querySelector(`.simple-flow-height`).innerText = `simple-flow-height : ${node.data.simpleFlowHeight}`;
            // htmlElem.querySelector(`.elem-height`).innerText = `elem-height : ${htmlElem.offsetHeight}`;
            // htmlElem.querySelector(`.name`).innerText = `name : ${node.name}`;
            this.updateNode(node.id);
        });
    }

    // override
    key(e) {
        super.key(e);
        if (this.editor_mode === 'fixed') {
            return false;
        }
        if (this.first_click?.tagName !== 'INPUT' && this.first_click.tagName !== 'TEXTAREA' && this.first_click.hasAttribute('contenteditable') !== true) {
            if (e.ctrlKey && e.key === 'c') {
                if (this.node_selected !== null) {
                    this.nodeToCopyStringified = JSON.stringify(this.getNodeFromId(this.node_selected.id.slice(5)));
                }
            }
            if (e.ctrlKey && e.key === 'v') {
                if (this.nodeToCopyStringified) {
                    // get mouse position
                    if (this.x && this.y) {
                        // insert node
                        const { data: { node } } = JSON.parse(this.nodeToCopyStringified);
                        // console.log(node);
                        console.log(this.addNewNode({ pos: { x: this.x, y: this.y }, node }));
                        // console.log(this.x, this.y);
                    }
                    // this.nodeToCopyStringified = null;
                }
            }

        }

    }

    nodeParentId(nodeId) {
        return this.getNodeFromId(nodeId)?.inputs?.input_1?.connections[0]?.node;
    }

    getHeadOfFlow(nodeId) {
        let parent = this.nodeParentId(nodeId);
        while (parent) {
            nodeId = parent;
            parent = this.nodeParentId(nodeId);
        }
        return nodeId;
    }

    nodeHtmlElem(nodeId) {
        return document.getElementById(`node-${nodeId}`);
    }

    nodeIsCondition(nodeId) {
        return Object.keys(this.getNodeFromId(nodeId).outputs).length === 2;
    }

    nodeIsEnd(nodeId) {
        return Object.keys(this.getNodeFromId(nodeId).outputs).length === 0;
    }

    align(nodeId) {
        // return 0;
        let parent = this.nodeParentId(nodeId);
        while (parent && !this.nodeIsCondition(parent)) {
            nodeId = parent;
            parent = this.nodeParentId(nodeId);
        }

        const simpleFlow = [nodeId];
        let nodeIdTmp = nodeId;
        let pos_x, pos_y;

        while (!this.nodeIsCondition(nodeIdTmp) && !this.nodeIsEnd(nodeIdTmp) && this.nodeAllOutConnections(nodeIdTmp).length) {
            nodeIdTmp = this.getNodeFromId(nodeIdTmp).outputs.output_1.connections[0].node;
            simpleFlow.push(nodeIdTmp);
        }

        if (!this.nodeParentId(nodeId)) {
            pos_x = this.getNodeFromId(nodeId).pos_x;
            pos_y = this.getNodeFromId(nodeId).pos_y + this.nodeHtmlElem(nodeId).offsetHeight / 2;
        } else {
            // has parent that is condition
            pos_x = this.getNodeFromId(this.nodeParentId(nodeId)).pos_x + this.nodeHtmlElem(this.nodeParentId(nodeId)).offsetWidth + this.spacing_x;
            pos_y = this.getNodeFromId(this.nodeParentId(nodeId)).pos_y + this.nodeHtmlElem(this.nodeParentId(nodeId)).offsetHeight / 2;
            if (this.nodeIsCondition(nodeIdTmp)) {
                // console.log(this.getNodeFromId(nodeIdTmp).data.flowHeight, this.nodeHtmlElem(nodeIdTmp).offsetHeight);
                if (this.getNodeFromId(nodeId).inputs.input_1.connections[0].input === 'output_2') {
                    pos_y += this.spacing_y / 2 + (this.getNodeFromId(nodeIdTmp).outputs.output_1.connections.length ? this.getNodeFromId(this.getNodeFromId(nodeIdTmp).outputs.output_1.connections[0].node).data.flowHeight + this.spacing_y / 2 : this.getNodeFromId(nodeIdTmp).data.simpleFlowHeight / 2);
                } else {
                    pos_y -= this.spacing_y / 2 + (this.getNodeFromId(nodeIdTmp).outputs.output_2.connections.length ? this.getNodeFromId(this.getNodeFromId(nodeIdTmp).outputs.output_2.connections[0].node).data.flowHeight + this.spacing_y / 2 : this.getNodeFromId(nodeIdTmp).data.simpleFlowHeight / 2);
                }
            } else {
                // is last in simple flow
                const dY = this.spacing_y / 2 + this.getNodeFromId(nodeIdTmp).data.flowHeight / 2;
                const isBottom = this.getNodeFromId(nodeId).inputs.input_1.connections[0].input === 'output_2';
                pos_y += isBottom ? dY : -dY;
            }
        }

        simpleFlow.forEach(flowElemId => {
            this.updateNode(flowElemId, { pos_x, pos_y: (pos_y - this.nodeHtmlElem(flowElemId).offsetHeight / 2) });
            pos_x += this.spacing_x + this.nodeHtmlElem(flowElemId).offsetWidth;
        });

        if (this.nodeIsCondition(nodeIdTmp)) {
            this.nodeAllOutConnections(nodeIdTmp).forEach(conn => this.align(conn.node));
        }
    }

    elemFlowHeight(nodeId) {
        let parent = this.nodeParentId(nodeId);
        while (parent && !this.nodeIsCondition(parent)) {
            nodeId = parent;
            parent = this.nodeParentId(nodeId);
        }

        let nodeIdTmp = nodeId;
        const simpleFlow = [nodeIdTmp];
        let maxHeight = this.nodeHtmlElem(nodeIdTmp).offsetHeight;
        let simpleFlowHeight = maxHeight;
        while (!this.nodeIsCondition(nodeIdTmp) && !this.nodeIsEnd(nodeIdTmp) && this.nodeAllOutConnections(nodeIdTmp).length) {
            nodeIdTmp = this.getNodeFromId(nodeIdTmp).outputs.output_1.connections[0].node;
            simpleFlow.push(nodeIdTmp);
            maxHeight = Math.max(maxHeight, document.getElementById(`node-${nodeIdTmp}`).offsetHeight);
        }
        if (this.nodeIsCondition(nodeIdTmp)) {
            const { outputs } = this.getNodeFromId(nodeIdTmp);
            let up = outputs.output_1.connections;
            let down = outputs.output_2.connections;
            up = up.length && (this.elemFlowHeight(up[0].node) + this.spacing_y / 2);
            down = down.length && (this.elemFlowHeight(down[0].node) + this.spacing_y / 2);
            up = Math.max(up, maxHeight / 2);
            down = Math.max(down, maxHeight / 2);
            maxHeight = Math.max(maxHeight, up + down);
        }
        simpleFlow.forEach((flowElemId) => {
            this.updateNode(flowElemId, { data: { flowHeight: maxHeight, simpleFlowHeight } });
        });
        return maxHeight;
    }

    // override
    click(e) {
        super.click(e);

        // Remember starting place of element whe drag begins
        // (for nodes which can be detached if draggad away from their place)
        if (this?.ele_selected?.classList[0] === 'drawflow-node') {
            const node = this.ele_selected;
            const node_id = node.id.slice(5);
            const node_info = this.getNodeFromId(node_id);

            if (node_info.inputs?.input_1?.connections.length) {
                const { left, top } = this.ele_selected.getBoundingClientRect();
                this.startPos = { left, top };
            }
        }
    }

    // override
    position(e) {
        super.position(e);
        if (e.type === "touchmove") {
            var e_pos_x = e.touches[0].clientX;
            var e_pos_y = e.touches[0].clientY;
        } else {
            var e_pos_x = e.clientX;
            var e_pos_y = e.clientY;
        }
        this.x = e_pos_x * (this.precanvas.clientWidth / (this.precanvas.clientWidth * this.zoom)) - (this.precanvas.getBoundingClientRect().x * (this.precanvas.clientWidth / (this.precanvas.clientWidth * this.zoom)));
        this.y = e_pos_y * (this.precanvas.clientHeight / (this.precanvas.clientHeight * this.zoom)) - (this.precanvas.getBoundingClientRect().y * (this.precanvas.clientHeight / (this.precanvas.clientHeight * this.zoom)));
        if (this.drag) {
            const node = this.ele_selected;
            const node_id = node.id.slice(5);
            const node_info = this.getNodeFromId(node_id);
            const { outputs, inputs } = node_info;
            let numInputConnections;
            if (Object.keys(inputs).length)
                numInputConnections = inputs.input_1.connections.length;
            else numInputConnections = 0;
            let numOutputConnections = 0;
            Object.values(outputs).forEach(output => numOutputConnections += output.connections.length);

            if (numInputConnections) {
                // TODO - done: Check length from previous position and if longer than some val, then - disconnect
                const { left, top } = node.getBoundingClientRect();
                const distance = Math.hypot(left - this.startPos.left, top - this.startPos.top);
                // console.log(distance);
                if (distance > this.distanceToDisconnect) {
                    const in_conn = node_info.inputs.input_1.connections[0];
                    this.removeSingleConnection(in_conn.node, node_id, in_conn.input, 'input_1');
                }
            } else if (!numInputConnections && 'input_1' in node_info.inputs) {
                const nodeInputElem = document.getElementById(`node-${node_id}`).querySelector('.input_1');
                const allNodes = Object.values(this.drawflow.drawflow[this.module].data);
                const otherNodes = allNodes.filter(node => node.data.flow !== node_id);
                // console.log(otherNodes);
                // get outputs of these nodes

                const { top, left } = nodeInputElem.getBoundingClientRect();
                let outputs = [].concat(...otherNodes.map(node => [...document.getElementById(`node-${node.id}`).querySelectorAll('.output')]));
                outputs = outputs.map(output => {
                    const pos = output.getBoundingClientRect();
                    const distance = Math.hypot(left - pos.left, top - pos.top);
                    return { output, distance };
                });
                outputs.sort((a, b) => (a.distance - b.distance));
                if (outputs.length) {
                    const nearestOutput = outputs[0].output;
                    if (outputs[0].distance < this.distanceToConnect) {
                        if (!nearestOutput.firstChild) {
                            this.indicator.parentNode?.removeChild(this.indicator);
                            nearestOutput.appendChild(this.indicator);
                        }
                        this.indicator.classList.remove('invisible');
                        const output_class = nearestOutput.classList[1];
                        this.attachTo = { output_class, nodeOutId: nearestOutput.closest('.drawflow-node').id.slice(5) };
                    } else {
                        this.indicator.classList.add('invisible');
                        this.attachTo = false;
                    }
                }
            }
        }
    }

    // override
    dragEnd(e) {
        const drag = this.drag;
        const node = this.ele_selected;
        super.dragEnd(e);
        // if was dragging an element
        if (drag && node) {
            const nodeInId = node.id.slice(5);
            if (this.attachTo) {
                const { nodeOutId, output_class } = this.attachTo;
                const nodeOutInfo = this.getNodeFromId(nodeOutId);
                const isSimpleFlow = this.isSimpleFlow(nodeInId);
                const nodeOutConnections = nodeOutInfo.outputs[output_class].connections;
                if (nodeOutConnections.length && isSimpleFlow && this.getNodeFromId(isSimpleFlow).outputs.output_1) {
                    // insert in the middle
                    this.removeSingleConnection(nodeOutId, nodeOutConnections[0].node, output_class, "input_1");
                    this.addConnection(isSimpleFlow, nodeOutConnections[0].node, "output_1", "input_1");
                    this.addConnection(nodeOutId, nodeInId, output_class, "input_1");
                } else if (!nodeOutConnections.length) {
                    // just connect to the tail of flow
                    this.addConnection(nodeOutId, nodeInId, output_class, "input_1");
                }
                this.attachTo = false;
                this.indicator.classList.add('invisible');
            }
            this.updateAllFlows();
        }
    }

    // override
    // export() {
    //     const drawflow = super.export();
    //     const modules = drawflow.drawflow;
    //     for (let moduleName in modules) {
    //         const nodes = modules[moduleName].data;
    //         for (let nodeId in nodes) {
    //             delete nodes[nodeId].html;
    //         }
    //     }
    //     return drawflow;
    // }
}
