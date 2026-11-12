"""Read the approved SO list without changing the source workbook."""
import argparse
import hashlib
import json
from pathlib import Path
import xml.etree.ElementTree as ET
from zipfile import ZipFile


def read_workbook(path):
    ns = {"m": "http://schemas.openxmlformats.org/spreadsheetml/2006/main"}
    with ZipFile(path) as archive:
        strings = ["".join(t.itertext()) for t in ET.fromstring(archive.read("xl/sharedStrings.xml")).findall("m:si", ns)]
        rows = []
        for row in ET.fromstring(archive.read("xl/worksheets/sheet1.xml")).findall(".//m:sheetData/m:row", ns):
            cells = {}
            for cell in row.findall("m:c", ns):
                value = cell.find("m:v", ns)
                if value is not None:
                    cells["".join(c for c in cell.attrib["r"] if c.isalpha())] = strings[int(value.text)] if cell.get("t") == "s" else value.text
            if int(row.attrib["r"]) == 4:
                if [cells.get(c) for c in ("D", "G", "I")] != ["Nomor SO", "Kode Barang", "Qty SO"]:
                    raise ValueError("Unexpected source columns")
            if int(row.attrib["r"]) >= 5 and cells.get("D"):
                rows.append({"excel_row": int(row.attrib["r"]), "so_number": cells["D"].strip(), "item_code": cells.get("G", "").strip(), "item_name": cells.get("H", "").strip(), "qty": cells["I"]})
    if len(rows) != 21 or len({r["so_number"] for r in rows}) != 9 or sum(float(r["qty"]) for r in rows) != 57:
        raise ValueError("Source differs from the approved 21 rows, 9 SO, 57 units")
    return {"source_sha256": hashlib.sha256(Path(path).read_bytes()).hexdigest(), "cutoff": "2026-10-20 10:00:00", "timezone": "Asia/Jakarta", "quantity_policy": "fixed_excel", "rows": rows}


if __name__ == "__main__":
    parser = argparse.ArgumentParser()
    parser.add_argument("workbook")
    parser.add_argument("--output", required=True)
    args = parser.parse_args()
    output = Path(args.output)
    output.parent.mkdir(parents=True, exist_ok=True)
    output.write_text(json.dumps(read_workbook(args.workbook), ensure_ascii=False, indent=2), encoding="utf-8")
    print("Read 21 source rows, 9 SO, 57 units; source workbook unchanged.")
