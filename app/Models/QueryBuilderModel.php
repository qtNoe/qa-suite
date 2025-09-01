<?php 

    class QueryBuilderModel extends z_model {

        public function selectAllUsers() {
            $query = $this->select("id, email", "z_user");

            return $this->exec($query)->resultToArray();
        }

        public function selectUserById($id) {
            $query = $this->select("id, email", "z_user")
                            ->where(["id" => $id]);

            return $this->exec($query)->resultToArray();
        }

        public function selectUserExtended() {
            $query = $this->select("u.id, u.email", "z_user u")
                            ->where(["u.id" => 1])
                            ->where(["u.email" => "admin@zierhut-it.de"]);

            return $this->exec($query)->resultToArray();
        }

        public function selectUserJoin() {
            $query = $this->select("u.id, u.email, r.name", "z_user u")
                            ->join([
                                "ur" => [
                                    "table" => "z_user_role",
                                    "conditions" => "ur.user = u.id",
                                    "type" => "LEFT"
                                ],
                                "r" => [
                                    "table" => "z_role",
                                    "conditions" => "ur.role = r.id",
                                    "type" => "LEFT"
                                ]
                            ])
                            ->where(["u.id" => 1]);

            return $this->exec($query)->resultToArray();
        }

        public function selectUserLike() {
            $query = $this->select("u.id, u.email", "z_user u")
                            ->where(["u.email LIKE" => "%admin%"]);

            return $this->exec($query)->resultToArray();
        }

        public function selectUserLT() {
            $query = $this->select("u.id, u.email", "z_user u")
                            ->where(["u.id <" => 3]);

            return $this->exec($query)->resultToArray();
        }

        public function selectUserIn() {
            $query = $this->select("u.id, u.email", "z_user u")
                            ->where(["u.id IN" => [1, 2]]);
            return $this->exec($query)->resultToArray();
        }

        public function selectUserORAND() {
            $query = $this->select("u.id, u.email", "z_user u")
                            ->where([
                                "OR" => [
                                    "u.id" => 1,
                                    "u.email LIKE" => "%support%"
                                ],
                                "AND" => [
                                    "u.languageId" => 0
                                ]
                            ]);
            return $this->exec($query)->resultToArray();
        }

        public function selectUserLimit() {
            $query = $this->select("u.id, u.email", "z_user u")
                            ->limit(2)
                            ->page(2);
            return $this->exec($query)->resultToArray();
        }

        public function selectUserOrder() {
            $query = $this->select("u.id, u.email", "z_user u")
                            ->order("u.id DESC");
            return $this->exec($query)->resultToArray();
        }

        public function selectUserGroup() {
            $query = $this->select("COUNT(*)", "z_user u")
                            ->group("u.languageId")
                            ->having(["COUNT(u.id) >" => 1]);
            return $this->exec($query)->resultToArray();
        }

        public function selectLanguageById($id) {
            $query = $this->select("*", "z_language")
                            ->where(["id" => $id]);

            return $this->exec($query)->resultToLine();
        }

        public function insertLanguage() {
            $query = $this->insert("z_language", [
                "name" => "TestLanguage1",
                "nativeName" => "TestLanguageNative1",
                "value" => "tl1"
            ]);

            $this->exec($query);

            $query = $this->insert("z_language", [
                "name" => "TestLanguage2",
                "nativeName" => "TestLanguageNative2",
                "value" => "tl2"
            ])->values([
                "name" => "TestLanguage3",
                "nativeName" => "TestLanguageNative3",
                "value" => "tl3"
            ]);

            $this->exec($query);
        }

        public function updateLanguage() {
            $query = $this->update("z_language", [
                "name" => "UpdatedTestLanguage1",
                "nativeName" => "UpdatedTestLanguageNative1",
                "value" => "utl1"
            ])
            ->where(["id" => 1]);

            $this->exec($query);
        }

        public function deleteLanguage() {
            $query = $this->delete("z_language")
                ->where(["id" => 1]);

            $this->exec($query);
        }
    }

?>