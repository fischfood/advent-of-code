#!/usr/bin/env python3
"""
ILP helper using PuLP. Reads JSON on stdin with keys:
  - wiring: list[list[int]]  (buttons -> affected lights)
  - target: list[int]        (required sum per light)
  - max_presses: list[int]   (upper bound per button)

Tries to use GLPK (if available) via PuLP's GLPK_CMD solver, otherwise falls back to CBC.
Outputs JSON: {"presses": [...], "total": int} or {"presses": null, "total": null} if infeasible.

Install:
  brew install glpk
  pip3 install pulp

Run test:
  echo '{"wiring":[[0,1],[1,2]],"target":[1,2,0],"max_presses":[3,3]}' | python3 ilp_helper.py
"""
import sys
import json

try:
    import pulp
except Exception as e:
    print(json.dumps({"presses": None, "total": None, "error": "pulp not installed: %s" % str(e)}))
    sys.exit(1)


def solve(wiring, target, max_presses):
    n_buttons = len(wiring)
    n_lights = len(target)

    prob = pulp.LpProblem('min_presses', pulp.LpMinimize)

    # Integer variables
    presses = [pulp.LpVariable(f'p{b}', lowBound=0, upBound=max_presses[b], cat='Integer') for b in range(n_buttons)]

    # Constraints: for each light, sum of presses affecting it == target
    for l in range(n_lights):
        expr = None
        for b in range(n_buttons):
            if l in wiring[b]:
                expr = presses[b] if expr is None else expr + presses[b]
        if expr is None:
            # no button affects this light -> require target 0
            if target[l] != 0:
                # infeasible
                return None
        else:
            prob += expr == target[l]

    total = pulp.lpSum(presses)
    prob += total

    # Try GLPK_CMD solver, fall back to CBC with msg=False
    solver = None
    try:
        solver = pulp.GLPK_CMD(msg=False)
        res = prob.solve(solver)
    except Exception:
        try:
            # CBC is the default, suppress its verbose output
            solver = pulp.PULP_CBC_CMD(msg=False)
            res = prob.solve(solver)
        except Exception:
            return None

    status = pulp.LpStatus.get(prob.status, None)
    if status is None:
        # older pulp versions
        status = pulp.LpStatus[prob.status]

    if str(status).lower() in ('optimal', '1'):
        solution = [int(pulp.value(var)) for var in presses]
        totalv = int(sum(solution))
        return {"presses": solution, "total": totalv}
    else:
        return None


def main():
    try:
        payload = json.load(sys.stdin)
    except Exception as e:
        print(json.dumps({"presses": None, "total": None, "error": "invalid json: %s" % str(e)}))
        return

    wiring = payload.get('wiring', [])
    target = payload.get('target', [])
    max_presses = payload.get('max_presses', [])

    # normalize
    wiring = [[int(x) for x in w] for w in wiring]
    target = [int(x) for x in target]
    max_presses = [int(x) for x in max_presses]

    res = solve(wiring, target, max_presses)
    if res is None:
        print(json.dumps({"presses": None, "total": None}))
    else:
        print(json.dumps(res))

if __name__ == '__main__':
    main()
